const state = {
    page: 'start'
  }

const mutations = {
    currentPage (state, page) {
        state.page = page;
    }
  }

const actions = {
    setCurrentPage({commit}, page) {
        commit("currentPage", page)
    }
}

export default {
  state,
  mutations,
  actions
}