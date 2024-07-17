@extends('public-website.layouts.default')

@push('plugin-styles')
@endpush

@push('plugin-scripts')
@endpush

@push('page-scripts')
@endpush

@section('content')
<section class="terms-section">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <div class="keypoint-section mb-5" data-aos="fade-down">
                    <h4 class="keypoint-title">TERMS & CONDITIONS</h4>
                </div>
            </div>
        </div>
        <div class="collapse info-card-area" id="terms-condition">
            <div class="info-card-block">
                <div class="row justify-content-around">
                    <div class="col-md-5 col-xl-4" data-aos="fade-right">
                        <div class="keypoint-section mb-5">
                            <h6 class="keypoint-desc">1</h6>
                            <p class="keypoint-alt-desc">By entering <strong>Fantasy League®</strong> (the "Game") through the website located at <strong><a href="#">www.fantasyleague.com</a></strong> (the "Website”) and associated domains, you are bound to play within the <strong>Terms & Conditions</strong> of the Game as specified by <strong>Fantasy League Limited</strong> ("Fantasy League").</p>
                            <p class="keypoint-alt-desc">
                                <strong>Fantasy League Limited is registered in England with the following address:</strong>
                            </p>
                            <p class="keypoint-alt-desc">
                                Bury House<br>
                                31 Bury Street<br>
                                London<br>
                                EC3A 5AR<br>
                            </p>
                            <p class="keypoint-alt-desc mb-5"><strong>Registered number:</strong> 03924186</p>
                            <h6 class="keypoint-desc">2</h6>
                            <p class="keypoint-alt-desc mb-5">Entries received after 12:30 BST on Saturday, 11 August will score points from matches played after the entries are received. Player points scored from matches played prior to entry will not be added retrospectively except on request.</p>
                            <h6 class="keypoint-desc">3</h6>
                            <p class="keypoint-alt-desc mb-5">Entries will only be accepted upon full payment of any fees due. If any payment is found to be invalid or not of the correct amount, teams associated with invalid or incorrect payments will be removed.</p>
                            <h6 class="keypoint-desc">4</h6>
                            <p class="keypoint-alt-desc mb-5">The entry fee for the Game is <strong>£10</strong> (Starter), <strong>£27</strong> (Standard), <strong>£29</strong> (Standard and League Series), <strong>£34</strong> (Interactive) or <strong>£39</strong> (Premium) per team entry, dependant on package purchased. A full refund, if requested with a valid reason, can be made within seven days of purchase. Separate fee structures may have been negotiated with leagues outside of these standardised prices.</p>
                            <h6 class="keypoint-desc">5</h6>
                            <p class="keypoint-alt-desc mb-5">There is no limit to the number of entries per person.</p>
                            <h6 class="keypoint-desc">6</h6>
                            <p class="keypoint-alt-desc mb-5">Incorrect, incomplete or corrupted entries will not be accepted. The computer record of the entry will be considered to be the entry. The decision of <strong>Fantasy League</strong> is final.</p>
                            <h6 class="keypoint-desc">7</h6>
                            <p class="keypoint-alt-desc mb-5"><strong>Fantasy League</strong> reserves the right to refuse to accept team names that are felt in its sole opinion to be inappropriate or offensive. Unsuitable names will be altered to the username of the team's manager.</p>
                            <h6 class="keypoint-desc">8</h6>
                            <p class="keypoint-alt-desc mb-5">The players included on the player list and their positional classifications have been determined by <strong>Fantasy League</strong>. <strong>Fantasy League</strong> will not enter into any correspondence relating to details of the player list, nor will they accept the inclusion into a team of any player not on the published list. New players will be added to the player list if they come into first team reckoning at a Premier League club at the discretion of <strong>Fantasy League</strong>. Players changing clubs within the Premier League will also change clubs on the player list. However, this will not invalidate a team if two players from the new club are already owned. The new club will, however, be taken into account when making any transfers into a team.</p>
                            <h6 class="keypoint-desc">9</h6>
                            <p class="keypoint-alt-desc"><strong>Entrants will score points as follows:</strong></p>
                            <p class="keypoint-alt-desc"><strong>3 points</strong> for every goal scored (not own goals) by one of your players </p>
                            <p class="keypoint-alt-desc"><strong>2 points</strong> for every assist (goal made) by one of your players </p>
                            <p class="keypoint-alt-desc"><strong>1 appearance point</strong> for a goalkeeper or defender playing 45 minutes or more of a match </p>
                            <p class="keypoint-alt-desc mb-5"><strong>2 additional points</strong> for a goalkeeper or defender who does not concede a goal whilst on the pitch, providing they play for 75 completed minutes or more (i.e. not substituted off before the 76th minute.) Goalkeepers and defenders will lose <strong>1 point</strong> for every goal conceded whilst they are on the pitch. Goalkeepers and defenders that receive red cards can lose points after they are sent off. If a player is sent off and his team concedes goals after his dismissal, he continues to lose the points that his teammates do. If the goalkeeper or defender is sent off and his team keep a clean sheet, he keeps the points as at the time he was sent off.</p>
                            <h6 class="keypoint-desc">10</h6>
                            <p class="keypoint-alt-desc mb-5"><strong>Team Changes</strong> (transfers and substitutions) can take place right up until scheduled kick-off times. This means that even if matches are still being played, you can make changes for subsequent fixtures without losing points for players in the current match. You can also use the <strong>Super Subs</strong> feature to set up your line-up for each fixture block in advance. However, it is important to note that if a player is not in your starting line-up at the scheduled kick-off time, then he will not score any points for your team. If you are having any problems making subs or transfers, then please try again at a later time if possible. If not then send an e-mail to our customer support address, outlining any changes you are trying to make and we'll get these done retrospectively for you, as long as you email before the relevant kick-off time of the affected fixtures.</p>
                        </div>
                    </div>
                    <div class="col-md-5 col-xl-4" data-aos="fade-left">
                        <div class="keypoint-section mb-5">
                            <h6 class="keypoint-desc">11</h6>
                            <p class="keypoint-alt-desc mb-5">A player gains an assist by making the last completed pass to a goalscorer before a goal is scored, and is only applicable to members of the scoring team. If the last touch before a goal scorer is by an opposing player and the touch significantly alters the speed or direction of the ball (excluding a goal-line clearance), then no assist is given. If the last touch before a goal scorer is from a team-mate but his touch does not significantly alter the speed or direction of the ball, then two separate assists are given - one for each of the players setting up the goal. In the event of a penalty, the fouled player gets an assist if the penalty kick is successfully scored, unless the fouled player is also the goalscorer - in which case no assist is given. No assist is given for a player who earns a free-kick that subsequently directly results in a goal. If a goalkeeper parries a shot or drops a cross, the attacking player shooting or crossing the ball still receives an assist if a goal directly ensues. The only time a goalkeeper removes the assist is if he intentionally punches the ball out as he is judged to have been in control of the ball. The decision of <strong>Fantasy League</strong> will be final on all these matters.</p>
                            <h6 class="keypoint-desc">12</h6>
                            <p class="keypoint-alt-desc mb-5">The rules, point structure, player lists and assist awards scheme are all copyright <strong>Fantasy League</strong>. No information may be reproduced in any format without prior written consent from <strong>Fantasy League</strong>.</p>
                            <h6 class="keypoint-desc">13</h6>
                            <p class="keypoint-alt-desc mb-5">Informative and explanatory copy relating to <strong>Fantasy League</strong>, including the scoring system and rules, form part of the <strong>Terms & Conditions of the Game.</strong></p>
                            <h6 class="keypoint-desc">14</h6>
                            <p class="keypoint-alt-desc mb-5"><strong>Fantasy League</strong> reserve the right themselves to refuse to accept any entry which, in their opinion, does not comply with the rules and regulations of the competition or which contravenes the spirit of the Game. <strong>Fantasy League</strong> further have an absolute discretion to disqualify any entry, or vary, amend or waive the rules of the competition at any time and participants agree that no liability shall attach to <strong>Fantasy League</strong> as a result thereof and that the exercise of such discretion shall not result in any compensation being payable or paid to any participant. It is a condition of entry that all rules are accepted as final and that the competitor agrees to abide by these rules.</p>
                            <h6 class="keypoint-desc">15</h6>
                            <p class="keypoint-alt-desc mb-5">Any site users or managers found to be attempting or suspected of attempting to hack into any servers or systems run by <strong>Fantasy League</strong> will be immediately removed from the system and have any subscriptions or payments cancelled. Such users will have no recourse to any refunds and Fantasy League reserves the right to report the matter to the relevant authorities.</p>
                            <h6 class="keypoint-desc">16</h6>
                            <p class="keypoint-alt-desc mb-5">No monetary prizes will be awarded. However, medals and trophies are allocated to leagues as described on the <strong>Prices & Packages</strong> page.</p>
                            <h6 class="keypoint-desc">17</h6>
                            <p class="keypoint-alt-desc mb-5">By submitting a team into a <strong>Free Trial</strong> league, you accept the <strong>Free Trial</strong> offer and consent to us closing off access to the <strong>Fantasy League Professional</strong> service after the end of the <strong>Free Trial Period.</strong> If you decide that you want to become a paying user upon the lapse of the <strong>Free Trial Period</strong>, you will need to submit payment for the product in order to continue. You may only use this <strong>Free Trial</strong> offer once. <strong>Fantasy League</strong> reserves the right, in its absolute discretion, to withdraw or to modify this <strong>Free Trial</strong> offer and the terms and conditions associated with it at any time without prior notice and with no liability.</p>
                            <h6 class="keypoint-desc">18</h6>
                            <p class="keypoint-alt-desc mb-5">The <strong>'Member Get Member'</strong> offer is available exclusively for website referrals to <strong>Fantasy League</strong> and is open to all Fantasy League participants from the 2017/18 season. The new league must include six new (i.e. didn't play in 2017/18) paid managers for any benefits to be accrued and the referring league must also have at least six paid managers who participated in 2017/18. <strong>Fantasy League</strong> reserves the right to change, add or amend the <strong>'Member Get Member'</strong> offer and terms or to suspend this promotion without prior notice.</p>

                            <h6 class="keypoint-desc">19</h6>
                            <p class="keypoint-alt-desc"><strong>Complaints and queries can be sent to the following:</strong></p>
                            <p class="keypoint-alt-desc">
                                Fantasy League Limited<br>
                                51 Puttocks Drive<br>
                                Welham Green<br>
                                North Mymms<br>
                                Hatfield<br>
                                AL9 7LW
                            </p>
                            <p class="keypoint-alt-desc"><strong>Email:</strong> <a href="">auctionsupport@fantasyleague.com</a></p>
                            <p class="keypoint-alt-desc"><strong>Telephone:</strong> 0203 286 0540</p>
                        </div>
                        <div class="keypoint-section mb-5">
                            <div class="star-group"><span class="fl fl-stars"></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a class="collapse-action-btn" href="JavaScript:Void(0)"  data-toggle="collapse" data-target="#terms-condition" aria-expanded="false" aria-controls="terms-condition">
            <span class="fl fl-angle-up"></span>
        </a>
    </div>
</section>
@endsection

@push('modals')
@endpush
