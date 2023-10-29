<template>
    <div>
        <div class="modal" v-if="item">
            <div class="modal-content">
                <h2>{{ item.name }}</h2>
                <p>Name: {{ item.name }}</p>
                <p>Overview: {{ item.overview }}</p>
                <p>Popularity: {{ item.popularity }}</p>
                <p>Vote average: {{ item.voteAverage }}</p>
                <p>Vote count: {{ item.VoteCount }}</p>
                <p>Status: {{ item.status }}</p>
                <p>Poster: <img class="poster" v-bind:src="'https://image.tmdb.org/t/p/w600_and_h600_bestv2' + item.poster"></p>
                <p>Genres: {{ item.genres }}</p>
                <p>Language: {{ item.language }}</p>
                <button @click="closeModal">Close</button>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        props: ['selectedId'],
        data() {
            return {
                item: null,
            };
        },
        watch: {
            selectedId: 'fetchModalData'
        },
        created() {
            this.fetchModalData();
        },
        methods: {
            fetchModalData() {
                if (this.selectedId) {
                    axios.get(`/api/movie/${this.selectedId}`)
                        .then(response => {
                            this.item = response.data;
                        })
                        .catch(error => {
                            console.error('Error fetching modal data:', error);
                        });
                }
            },
            closeModal() {
                this.$emit('closeModal');
            },
        },
    };

</script>

<style scoped>
    .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
        display: flex;
        justify-content: center;
        align-items: center;
        padding-top: 50px;
    }

    .modal-content {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    }

    .poster {
        width: 100px;
        height: 100px;
    }
</style>
