require('./../../bootstrap');

window.Vue = require('vue');

import axios from 'axios';
import VueAxios from 'vue-axios';
import VueLodash from 'lodash';

import Vuex from 'vuex'
import { vuexfireMutations, firestoreAction } from 'vuexfire'
import { db } from './db'

Vue.use(Vuex, VueAxios, axios, VueLodash);

axios.defaults.headers.common = {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
};

Vue.component('onlineauction', require('./index.vue'));

import Auctiontioneer from './modules/auctiontioneer'
var moment = require('moment');

const store = new Vuex.Store({
    state: {
        isCloseAuction: false,
        teamManagers: [],
        players: [],
        playerAuction: {
            player_first_name: '',
            player_last_name: '',
            player: '',
            player_id: 0,
            opening_bid: 0,
            opening_bid_manager_id: '',
            opening_bid_manager_name: '',
            round: 1,
            position: '',
            club: '',
            club_short_code: ''
        },
        remoteManagers: [],
        auctiontioneerScreen: '',
        soldPlayers: [],
        tempAuctiontioneerScreen: 'temp',
        league: '',
        currentRound: 0,
        currentBidManagerTeamID: 0,
        currentBidManagerIndex: 0,
        rmBidTimestamp: '',
        nominateRMPlayerTimestamp: '',
        defaultBidTime: 15,
        divisionId: 0,
        currentTimestamp: '',
        errorMsg: ''
    },
    getters: {
        isCloseAuction(state) {
            if(state.isCloseAuction != null && typeof state.isCloseAuction.auction != "undefined") {
                state.isCloseAuction = state.isCloseAuction.auction
            }
            return state.isCloseAuction
        },
        players(state) {
            return state.players
        },
        teamManagers(state) {
            return state.teamManagers
        },
        playerAuction(state) {
            return state.playerAuction
        },
        remoteManagers(state) {
            state.remoteManagers = _.filter(state.teamManagers, ['is_remote', 1]);
            return state.remoteManagers
        },
        auctiontioneerScreen(state) {
            if(typeof state.auctiontioneerScreen.screen != "undefined") {
                state.auctiontioneerScreen = state.auctiontioneerScreen.screen
            }
            return state.auctiontioneerScreen
        },
        soldPlayers(state) {
            return state.soldPlayers;
        },
        tempAuctiontioneerScreen(state) {
            if(typeof state.auctiontioneerScreen.tempAuctiontioneerScreen != "undefined") {
                state.tempAuctiontioneerScreen = state.auctiontioneerScreen.tempAuctiontioneerScreen
            }
            return state.tempAuctiontioneerScreen
        },
        currentRound(state) {
            if(typeof state.currentRound.round != "undefined") {
                state.currentRound = state.currentRound.round
            }
            return state.currentRound;
        },
        currentBidManagerTeamID(state) {
            if(state.currentBidManagerTeamID != null && typeof state.currentBidManagerTeamID.team != "undefined") {
                state.currentBidManagerTeamID = state.currentBidManagerTeamID.team
            }
            return state.currentBidManagerTeamID   
        },
        currentBidManagerIndex(state) {
            if(state.currentBidManagerIndex != null && typeof state.currentBidManagerIndex.index != "undefined") {
                state.currentBidManagerIndex = state.currentBidManagerIndex.index
            }
            return state.currentBidManagerIndex   
        },
        rmBidTimestamp (state) {
            if(state.rmBidTimestamp != null && typeof state.rmBidTimestamp.timestamp != "undefined") {
                state.rmBidTimestamp = state.rmBidTimestamp.timestamp
            }
            return state.rmBidTimestamp        
        },
        nominateRMPlayerTimestamp (state) {
            if(state.nominateRMPlayerTimestamp != null && typeof state.nominateRMPlayerTimestamp.timestamp != "undefined") {
                state.nominateRMPlayerTimestamp = state.nominateRMPlayerTimestamp.timestamp
            }
            return state.nominateRMPlayerTimestamp        
        },
        defaultBidTime (state) {
            return state.defaultBidTime;
        },
        getDivisionId (state) {
            return state.divisionId;
        },
        currentTimestamp (state) {
            return state.currentTimestamp;    
        },
        errorMsg (state) {
            return state.errorMsg;    
        }
    },

    mutations: vuexfireMutations,

    actions: {
        updateIsCloseAuction: firestoreAction(({ state, bindFirestoreRef, unbindFirestoreRef, dispatch }, payload) => {
            var auctionStatus = db.collection(state.league).doc("Auctiontioneer").collection('isCloseAuction').doc('closeAuction');
            auctionStatus.get().then(function(auction) {
                if (!auction.exists) {
                    auctionStatus.set({auction: false})
                } else {
                    auctionStatus.set({auction: payload})
                }
                bindFirestoreRef('isCloseAuction', db.collection(state.league).doc("Auctiontioneer").collection('isCloseAuction').doc('closeAuction'))

            });
            
        }),
        setManagerScreen: firestoreAction(({ state, bindFirestoreRef, unbindFirestoreRef }, division) => {

            var league = "League" + division;
            state.league = league
            state.divisionId = division

            bindFirestoreRef('isCloseAuction', db.collection(league).doc("Auctiontioneer").collection('isCloseAuction').doc('closeAuction'))

            bindFirestoreRef('currentRound', db.collection(league).doc("Auctiontioneer").collection('currentRound').doc('round'))
            
            bindFirestoreRef('auctiontioneerScreen', db.collection(league).doc("Auctiontioneer").collection('auctiontioneerScreen').doc('screen'))

            bindFirestoreRef('currentBidManagerIndex', db.collection(league).doc("Auctiontioneer").collection('currentBidManagerIndex').doc('manager'))

            bindFirestoreRef('rmBidTimestamp', db.collection(league).doc("Auctiontioneer").collection('rmBidTimestamp').doc('timestamp'))
            bindFirestoreRef('nominateRMPlayerTimestamp', db.collection(league).doc("Auctiontioneer").collection('nominateRMPlayerTimestamp').doc('timestamp'))

            var screenRef = db.collection(league).doc("Auctiontioneer").collection('auctiontioneerScreen').doc('screen');
            screenRef.get().then(function(screen) {
                if (!screen.exists) {
                    state.auctiontioneerScreen = 'notStarted';
                } else {
                    state.auctiontioneerScreen = screen.data().screen
                    bindFirestoreRef('playerAuction', db.collection(league).doc("Auctiontioneer").collection('currentAuctionPlayer').doc('playerAuction'))
                    bindFirestoreRef('currentBidManagerTeamID', db.collection(league).doc("Auctiontioneer").collection('currentBidManagerTeamID').doc('currentManager'))
                    bindFirestoreRef('soldPlayers', db.collection(league).doc("Auctiontioneer").collection('playerAuctioned'));
                }
                bindFirestoreRef('teamManagers', db.collection(league).doc("Auctiontioneer").collection('teamManagers').orderBy('order'))

            });

        }),

        setCurrentPlayerAuctionData: firestoreAction(({ state, bindFirestoreRef, unbindFirestoreRef }, division) => {
            
            bindFirestoreRef('soldPlayers', db.collection(state.league).doc("Auctiontioneer").collection('playerAuctioned'));

            bindFirestoreRef('playerAuction', db.collection(state.league).doc("Auctiontioneer").collection('currentAuctionPlayer').doc('playerAuction'))    

        }),

        addTeamManagers: firestoreAction(({ state, bindFirestoreRef, dispatch }, data) => {

            var league = "League" + data[1];
            state.league = league
            state.divisionId = data[1];

            bindFirestoreRef('isCloseAuction', db.collection(league).doc("Auctiontioneer").collection('isCloseAuction').doc('closeAuction'))
            bindFirestoreRef('currentRound', db.collection(league).doc("Auctiontioneer").collection('currentRound').doc('round'))
            bindFirestoreRef('currentBidManagerIndex', db.collection(league).doc("Auctiontioneer").collection('currentBidManagerIndex').doc('manager'))
            bindFirestoreRef('rmBidTimestamp', db.collection(league).doc("Auctiontioneer").collection('rmBidTimestamp').doc('timestamp'))
            
            var screenRef = db.collection(league).doc("Auctiontioneer").collection('auctiontioneerScreen').doc('screen');
            screenRef.get().then(function(screen) {
                if (!screen.exists || screen.data().screen == "notStarted" || screen.data().screen == "start") {
                    if (!screen.exists || screen.data().screen == "notStarted") {
                        screenRef.set({screen: 'notStarted'})
                    } else {
                        screenRef.set({screen: 'start'})
                    }

                    _.forEach(data[0], function(value, key) {
                        var docRef = db.collection(league).doc("Auctiontioneer").collection('teamManagers').doc(value.team_id.toString());
                        docRef.get().then(function(doc) {
                            if (!doc.exists) {
                                docRef.set(value)
                            }
                        }).catch(function(error) {
                            console.log("Error getting document:", error);
                        });
                    });

                    var docRef = db.collection(state.league).doc("Auctiontioneer").collection('currentAuctionPlayer').doc('playerAuction');
                    docRef.set(state.playerAuction)

                    state.auctiontioneerScreen = "notStarted";
                    

                } else {
                    state.auctiontioneerScreen = screen.data().screen
                    bindFirestoreRef('playerAuction', db.collection(league).doc("Auctiontioneer").collection('currentAuctionPlayer').doc('playerAuction'))                    
                }
                bindFirestoreRef('currentBidManagerTeamID', db.collection(league).doc("Auctiontioneer").collection('currentBidManagerTeamID').doc('currentManager'))
            });

            bindFirestoreRef('teamManagers', db.collection(league).doc("Auctiontioneer").collection('teamManagers').orderBy('order'))

            bindFirestoreRef('soldPlayers', db.collection(league).doc("Auctiontioneer").collection('playerAuctioned'));

            bindFirestoreRef('auctiontioneerScreen', db.collection(league).doc("Auctiontioneer").collection('auctiontioneerScreen').doc('screen'))
            
            bindFirestoreRef('playerAuction', db.collection(league).doc("Auctiontioneer").collection('currentAuctionPlayer').doc('playerAuction'))
            
            bindFirestoreRef('nominateRMPlayerTimestamp', db.collection(league).doc("Auctiontioneer").collection('nominateRMPlayerTimestamp').doc('timestamp'))
        }),

        sortedTeamManagers: firestoreAction(({ state, bindFirestoreRef, unbindFirestoreRef }) => {

            bindFirestoreRef('teamManagers', db.collection(state.league).doc("Auctiontioneer").collection('teamManagers').orderBy('order'))
            state.remoteManagers = _.filter(state.teamManagers, ['is_remote', 1]);

        }),

        getAllPlayers: firestoreAction(({ state, bindFirestoreRef, unbindFirestoreRef, dispatch }) => {
            axios.get(route('manage.live.online.auction.search.players', {division: state.divisionId}))
            .then((response) => {
                var players = response['data'];
                state.players = players;
            })
            .catch((error) => {
                console.log(error);
            });

        }),

        updatePlayers: firestoreAction(({ state, bindFirestoreRef, unbindFirestoreRef }, player_id) => {
            _.remove(state.players, obj => [player_id].includes(obj.id))
        }),

        updateRemoteTeamManagers: firestoreAction(({ state, bindFirestoreRef, unbindFirestoreRef }, manager) => {

            var docRef = db.collection(state.league).doc("Auctiontioneer").collection('teamManagers').doc(manager[0]);

            return docRef.update({
                    is_remote: manager[1]
                })
                .then(function() {
                })
                .catch(function(error) {
                    // The document probably doesn't exist.
                    console.error("Error updating Manager: ", error);
                });

        }),

        setSortTeamManagers: firestoreAction(({ state, bindFirestoreRef }, data) => {

            _.forEach(data, function(value, key) {
                var docRef = db.collection(state.league).doc("Auctiontioneer").collection('teamManagers').doc(value.team_id.toString());
                docRef.get().then(function(doc) {
                    if (doc.exists) {
                        docRef.update({
                            order: key
                        })
                    }
                }).catch(function(error) {
                    console.log("Error getting document:", error);
                });

            });

            state.teamManagers = data

        }),

        setCurrentBidManagerTeamID: firestoreAction(({ state, bindFirestoreRef, dispatch }, teamId) => {
            var docRef = db.collection(state.league).doc("Auctiontioneer").collection('currentBidManagerTeamID').doc('currentManager');
            docRef.get().then(function(team) {
                if (team.exists) {
                    docRef.update({
                        team: teamId
                    })
                } else {
                    docRef.set({'team': teamId})
                }
                state.currentBidManagerTeamID = teamId;
                
            })
            .then(function() {
                var manager = _.head(_.filter(state.teamManagers, ['team_id', teamId]));
                if(manager.is_remote == 1) {
                    dispatch("setNominateRMPlayerTimestamp");                    
                }

                dispatch('updateCurrentBidManagerIndex', manager.order);

                bindFirestoreRef('nominateRMPlayerTimestamp', db.collection(state.league).doc("Auctiontioneer").collection('nominateRMPlayerTimestamp').doc('timestamp'))

            })
            .catch(function(error) {
                console.log("Error getting document:", error);
            });


        }),

        updateCurrentBidManagerIndex: firestoreAction(({ state, bindFirestoreRef, unbindFirestoreRef, dispatch }, order) => {

            var roundRef = db.collection(state.league).doc("Auctiontioneer").collection('currentBidManagerIndex').doc('manager');
            var updateIndex = 0;
            roundRef.get().then(function(round) {
                if (round.exists) {
                    updateIndex = parseInt(order); 
                    roundRef.update({
                        index: updateIndex
                    })
                } else {
                    updateIndex = 0;
                    roundRef.set({index: 0})
                }
                state.currentBidManagerIndex = updateIndex;
            })
            .then(function() {
            })
            .catch(function(error) {
                console.log("Error getting document:", error);
            });
            
        }),

        updatePlayerBid: firestoreAction(({ state, bindFirestoreRef, unbindFirestoreRef, dispatch }, bidData) => {
            var docRef = db.collection(state.league).doc("Auctiontioneer").collection('playerAuctioned').doc('player' + bidData.player_id);

            return docRef.update({
                    high_bidder_id: bidData.bidder_id,
                    high_bid_value: bidData.bid_price,
                    high_bidder_name: bidData.bidder_name,
                    team_id: bidData.team_id,
                })
                .then(function() {
                    sweet.success("Player bid updated");
                })
                .catch(function(error) {
                    // The document probably doesn't exist.
                    console.error("Error updating Screen: ", error);
                });

        }),

        cancelPlayerBid: firestoreAction(({ state, bindFirestoreRef, unbindFirestoreRef, dispatch }, player_id) => {
            var docRef = db.collection(state.league).doc("Auctiontioneer").collection('playerAuctioned').doc('player' + player_id).delete();
            setTimeout(function() {
                bindFirestoreRef('teamManagers', db.collection(state.league).doc("Auctiontioneer").collection('teamManagers').orderBy('order'))

                bindFirestoreRef('soldPlayers', db.collection(state.league).doc("Auctiontioneer").collection('playerAuctioned'));

                bindFirestoreRef('playerAuction', db.collection(state.league).doc("Auctiontioneer").collection('currentAuctionPlayer').doc('playerAuction'))    
            }, 500);
        }),

        changeAuctiontioneerScreen: firestoreAction(({ state, bindFirestoreRef, unbindFirestoreRef, dispatch }, screen) => {

            var docRef = db.collection(state.league).doc("Auctiontioneer").collection('auctiontioneerScreen').doc('screen');
            
            return docRef.update({
                    screen: screen
                })
                .then(function() {
                    state.auctiontioneerScreen = screen;
                })
                .catch(function(error) {
                    // The document probably doesn't exist.
                    console.error("Error updating Screen: ", error);
                });

        }),

        tempAuctiontioneerScreen: firestoreAction(({ state, bindFirestoreRef, unbindFirestoreRef, dispatch }, screen) => {

            var docRef = db.collection(state.league).doc("Auctiontioneer").collection('auctiontioneerScreen').doc('screen');
            
            return docRef.update({
                    tempAuctiontioneerScreen: screen
                })
                .then(function() {
                    state.tempAuctiontioneerScreen = screen;
                })
                .catch(function(error) {
                    // The document probably doesn't exist.
                    console.error("Error updating Screen: ", error);
                });

        }),

        removetempAuctiontioneerScreenFlag: firestoreAction(({ state, bindFirestoreRef, unbindFirestoreRef, dispatch }, screen) => {

            var docRef = db.collection(state.league).doc("Auctiontioneer").collection('auctiontioneerScreen').doc('screen');
            
            // Remove the 'tempAuctiontioneerScreen' field from the document
            docRef.set({
                screen: 'bidWinner'
            })
            .then(function() {
                    state.tempAuctiontioneerScreen = 'temp';
                })
                .catch(function(error) {
                    // The document probably doesn't exist.
                    console.error("Error updating Screen: ", error);
                });

        }),

        updateplayerAuction: firestoreAction(({ state, bindFirestoreRef, unbindFirestoreRef, dispatch }, details) => {
            var docRef = db.collection(state.league).doc("Auctiontioneer").collection('currentAuctionPlayer').doc('playerAuction');
            docRef.set(details[0], { merge: true }).then(() => {

                if(typeof details[1] != "undefined" && details[1] == 'updateTeamBudget') {
                    dispatch('updateTeamBudget', [state.playerAuction, details[0]])
                }
                else if(typeof details[1] != "undefined") {
                    dispatch('changeAuctiontioneerScreen', details[1])
                }

                bindFirestoreRef('playerAuction', db.collection(state.league).doc("Auctiontioneer").collection('currentAuctionPlayer').doc('playerAuction'))

            });
        }),

        updateTeamBudget: firestoreAction(({ state, bindFirestoreRef, unbindFirestoreRef, dispatch }, payload) => {
            axios.post(route('manage.live.online.auction.player.sold', {division: state.divisionId}), payload[0])
                .then((response) => {

                    if(response.data.success == true) {
                        state.errorMsg = ''

                        dispatch('updateTeamBudgetInFCM', {team_id: payload[1].team_id, bid_value:payload[0].high_bid_value})

                        dispatch("updatePlayerAuctionRound", "bidWinner")
                    } else {
                        state.errorMsg = response.data.message;
                    }

                })
                .catch((error) => {
                    console.log(error)
                });

        }),

        // this function is working fine
        updateTeamBudgetInFCM: firestoreAction(({ state, bindFirestoreRef, unbindFirestoreRef, dispatch }, payload) => {
            var teamManager = db.collection(state.league).doc("Auctiontioneer").collection('teamManagers').doc(payload.team_id.toString());
            teamManager.get().then(function(teamBudget) {
                if (teamBudget.exists) {
                    
                    var teamBudgetData = teamBudget.data();
                    var bidsWon = 1;
                    var squadSize = 1;

                    if(typeof(payload.set_bids_won) != 'undefined' && payload.set_bids_won == true) {
                        bidsWon = parseInt(teamBudgetData.bids_won) - 1;
                        squadSize = parseInt(teamBudgetData.squad_size) - 1;
                    } else {
                        if(typeof(teamBudgetData.bids_won) != 'undefined') {
                            bidsWon = parseInt(teamBudgetData.bids_won) + 1;
                        }
                        if(typeof(teamBudgetData.squad_size) != 'undefined') {
                            squadSize = parseInt(teamBudgetData.squad_size) + 1;
                        }
                    }

                    let tmpTeamBudget = parseFloat(teamBudgetData.team_budget) - parseFloat(payload.bid_value);

                    teamManager.update({
                        team_budget: tmpTeamBudget,
                        bids_won: bidsWon,
                        squad_size: squadSize
                    })
                }
            })
            .catch(function(error) {
                console.log("updateTeamBudget->Error getting document:", error);
            });
        }),

        updatePlayerAuctionRound: firestoreAction(({ state, bindFirestoreRef, unbindFirestoreRef, dispatch }, nextRound) => {
            var roundRef = db.collection(state.league).doc("Auctiontioneer").collection('currentRound').doc('round');
            var updateRound = 0;
            roundRef.get().then(function(round) {
                if (round.exists) {
                    updateRound = parseInt(round.data().round)+1;
                    roundRef.update({
                        round: updateRound
                    })
                } else {
                    updateRound = 1;
                    roundRef.set({'round': 1})
                }
                state.currentRound = updateRound;
            })
            .then(function() {
                if(nextRound != "") {
                    dispatch('changeAuctiontioneerScreen', nextRound)
                }
            })
            .catch(function(error) {
                console.log("Error getting document:", error);
            });
            
        }),

        finishBidProcess: firestoreAction(({ state, bindFirestoreRef, unbindFirestoreRef, dispatch }) => {
            
            var docRef = db.collection(state.league).doc("Auctiontioneer").collection('currentAuctionPlayer').doc('playerAuction');
            docRef.get().then(function(doc) {
                
                if (doc.exists) {
                    var data = doc.data()
                    data.round = state.currentRound;
                    
                    db.collection(state.league).doc("Auctiontioneer").collection('playerAuctioned').doc("player"+data.player_id).set(data);
                    db.collection(state.league).doc("Auctiontioneer").collection('auctiontioneerScreen').doc('screen').set({screen: 'start'})
                    db.collection(state.league).doc("Auctiontioneer").collection('currentAuctionPlayer').doc('playerAuction').delete()
                    
                    bindFirestoreRef('soldPlayers', db.collection(state.league).doc("Auctiontioneer").collection('playerAuctioned'));                    
                    
                    dispatch('setNominateRMPlayerTimestamp')

                    var playerAuction = {
                        player_first_name: '',
                        player_last_name: '',
                        player: '',
                        player_id: 0,
                        opening_bid: 0,
                        opening_bid_manager_id: '',
                        opening_bid_manager_name: '',
                        round: 1,
                        position: '',
                        club: '',
                        club_short_code: ''
                    };
                    var docRef = db.collection(state.league).doc("Auctiontioneer").collection('currentAuctionPlayer').doc('playerAuction');
                    docRef.set(playerAuction)

                    state.playerAuction = playerAuction;

                    bindFirestoreRef('playerAuction', db.collection(state.league).doc("Auctiontioneer").collection('currentAuctionPlayer').doc('playerAuction'))
                    
                }

                dispatch('changeAuctiontioneerScreen', 'nominatePlayer')

                axios.post(route('check.lon.isclosed', {division: state.divisionId}))
                .then((response) => {
                    if(response.data.status) {
                        dispatch('updateIsCloseAuction', response.data.status)
                    }                    
                })
                .catch((error) => {
                    console.log(error);
                });
            })

        }),

        submitRemoteManagerBid: firestoreAction(({ state, bindFirestoreRef, unbindFirestoreRef, dispatch }, details) => {
            var docRef = db.collection(state.league).doc("Auctiontioneer").collection('currentAuctionPlayer').doc('playerAuction');
            var sendArr = {'remote_manager' : {}};
            sendArr['remote_manager'][details.manager_id] = details.remote_bid

            docRef.set(sendArr, { merge: true }).then(() => {
            });
            
        }),

        updateManagerHighBid: firestoreAction(({ state, bindFirestoreRef, unbindFirestoreRef, dispatch }, screen) => {
            var docRef = db.collection(state.league).doc("Auctiontioneer").collection('currentAuctionPlayer').doc('playerAuction');
            var managers = _.sortBy(state.playerAuction.remote_manager)
            var maxRemoteBid = managers[managers.length-1];

            if(maxRemoteBid > state.playerAuction.high_bid_value) {
                var key = _.findKey(state.playerAuction.remote_manager, _.partial(_.isEqual, managers[managers.length-1]))
                var getPlayer = _.head(_.filter(state.teamManagers, [ 'manager_id', parseInt(key) ]));
                
                return docRef.update({
                    high_bid_value: maxRemoteBid,
                    high_bidder_id: getPlayer.manager_id,
                    high_bidder_name: getPlayer.first_name+" "+getPlayer.last_name,
                    team_id: getPlayer.team_id
                })
                .then(function() {
                    if(screen != '') {
                        state.auctiontioneerScreen = screen;
                        dispatch('changeAuctiontioneerScreen', screen)
                    }
                })
                .catch(function(error) {
                    // The document probably doesn't exist.
                    console.error("Error updating Screen: ", error);
                });

            } else {
                dispatch('changeAuctiontioneerScreen', screen)
            }
        }),
        setRMBidTimestamp: firestoreAction(({ state, bindFirestoreRef, unbindFirestoreRef, dispatch }) => {
            var docRef = db.collection(state.league).doc("Auctiontioneer").collection('rmBidTimestamp').doc('timestamp');
            
            axios.get(route('manage.lonauction.get.server.time'))
            .then((response) => {
                state.currentTimestamp = response.data.data;
                var timestamp = state.currentTimestamp + state.defaultBidTime; // state.defaultBidTime = 60
                docRef.set({ timestamp: timestamp }).then(() => {
                });
            })
            .catch((error) => {
                console.log(error);
            });

        }),
        setNominateRMPlayerTimestamp: firestoreAction(({ state, bindFirestoreRef, unbindFirestoreRef, dispatch }) => {
            var docRef = db.collection(state.league).doc("Auctiontioneer").collection('nominateRMPlayerTimestamp').doc('timestamp');

            axios.get(route('manage.lonauction.get.server.time'))
            .then((response) => {
                state.currentTimestamp = response.data.data;
                var timestamp = state.currentTimestamp + state.defaultBidTime; // state.defaultBidTime = 60
                docRef.set({ timestamp: timestamp }).then(() => {
                });
            })
            .catch((error) => {
                console.log(error);
            });
            
        }),
        removeNominateRMPlayerTimestamp: firestoreAction(({ state, bindFirestoreRef, unbindFirestoreRef, dispatch }) => {
            
            db.collection(state.league).doc("Auctiontioneer").collection('nominateRMPlayerTimestamp').doc('timestamp').delete()
            
        }),
        getCurrentTimestamp: firestoreAction(({ state, bindFirestoreRef, unbindFirestoreRef, dispatch }) => {

            axios.get(route('manage.lonauction.get.server.time'))
            .then((response) => {
                state.currentTimestamp = response.data.data;
            })
            .catch((error) => {
                console.log(error);
            });
        })
    },
    modules: {
        Auctiontioneer
    }
})


const app = new Vue({
    el: '#lonauction',
    store,
    data() {
        return {}
    },
    methods: {}
});
