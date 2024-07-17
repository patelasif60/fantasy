<template>
    <div>

        <ul class="nav nav-pills nav-justified theme-tabs theme-tabs-secondary mb-4" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="team-tab" data-toggle="pill" href="#team" role="tab" aria-controls="team" aria-selected="false">Team</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="player-tab" data-toggle="pill" href="#player" role="tab" aria-controls="player" aria-selected="false">Players</a>
            </li>
        </ul>

        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="team" role="tabpanel" aria-labelledby="team-tab">
                <div class="table-responsive">
                    <table class="table custom-table">
                        <thead class="thead-dark">
                            <tr>
                                <th>Team</th>
                                <th class="text-center">Bids won</th>
                                <th class="text-center">Budget</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div><a href="#" class="team-name link-nostyle">Richard's Team</a></div>
                                    <div><a href="#" class="player-name link-nostyle small">Richard stenson</a></div>
                                </td>
                                <td class="text-center">7</td>
                                <td class="text-center">£17</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="player" role="tabpanel" aria-labelledby="player-tab">Players</div>
        </div>

    </div>
</template>