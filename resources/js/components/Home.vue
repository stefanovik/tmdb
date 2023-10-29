<template>
    <div id="app">
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Genre(s)</th>
                <th>Release Date</th>
                <th>Details</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in apiData" :key="item.id">
                <td>{{ item.id }}</td>
                <td>{{ item.title }}</td>
                <td>{{ item.genres }}</td>
                <td>{{ item.releaseDate }}</td>
                <td>
                    <a @click="openModal(item.id)">
                        Full Info
                    </a>
                </td>
            </tr>
            </tbody>
        </table>
        <div>
            <button @click="previousPage" :disabled="currentPage === 1">Previous</button>
            <button @click="nextPage" :disabled="currentPage === pageCount">Next</button>
            <p> {{currentPage}} / {{pageCount}} </p>
        </div>
        <MovieModal v-if="isModalVisible" :selectedId="selectedId" @closeModal="closeModal" />
    </div>
</template>

<script>
    import axios from 'axios';
    import MovieModal from "./Modal/MovieModal.vue";

    export default {
        name: 'Home',
        components: {
            MovieModal
        },
        data() {
            return {
                apiData: [],
                pageSize: 10,
                pageCount: 0,
                isModalVisible: false,
                selectedId: null,
                currentPage: 1,
            };
        },
        created() {
            this.fetchDataWithPage(this.currentPage);
        },
        methods: {
            fetchDataWithPage(page) {
                axios.get('/api/movie/list', {
                    params: {
                        page: page,
                        pageSize: this.pageSize,
                    }
                })
                    .then(response => {
                        this.apiData = response.data.movies;
                        this.pageCount = Math.ceil(response.data.count / this.pageSize);
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                    });
            },
            openModal(id) {
                this.selectedId = id;
                this.isModalVisible = true;
            },
            closeModal() {
                this.isModalVisible = false;
            },
            previousPage() {
                if (this.currentPage > 1) {
                    this.currentPage--;
                }
                this.fetchDataWithPage(this.currentPage);
            },
            nextPage() {
                if (this.currentPage < this.pageCount) {
                    this.currentPage++;
                }
                this.fetchDataWithPage(this.currentPage);
            },
        },
    };
</script>
