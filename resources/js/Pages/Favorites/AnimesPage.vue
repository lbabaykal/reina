<script>
import CardLoading from "../../Components/CardLoading.vue";
import CardAnime from "../../Components/Animes/CardAnime.vue";
import Pagination from "../../Components/Pagination.vue";
import Folders from "../../Components/Animes/Folders.vue";

export default {
    name: "AnimesPage",
    components: {Folders, Pagination, CardAnime, CardLoading},
    data() {
        return {
            dataAnimes: [Array, Object],
            dataParams: {
                page: 1,
                folder: 0,
            },
            dataPagination: {
                links: [],
                current_page: Number,
                from: Number,
                last_page: Number,
                per_page: Number,
                to: Number,
                total: Number,
            },
            dataLoading: false,
        }
    },
    methods: {
        async getAnimesInFolderData() {
        this.dataLoading = false;
            await axios.get('/api/folders/animes/show',  { params: this.dataParams })
                .then(response => {
                    this.dataAnimes = response.data.data;
                    this.dataPagination = response.data.meta;
                    this.dataLoading = true;
                })
                .catch(error => {
                    if (error.status === 403) {
                        console.log('Не твоя папка')  //TODO уведомление что у пользователя нет прав на просмотр
                    }
                })
                .finally(() => {
                });
        },
        updateSelectedFolder(obj) {
            this.dataParams.folder = obj.selectedFolder;
            this.dataParams.page = 1;
            this.routerPush();
        },
        pageChange(page) {
            this.dataParams.page = page;
            this.routerPush();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        },
        loadParamsFromRoute() {
            const query = this.$route.query;

            this.dataParams = {
                page: Number(query.page) || 1,
                folder: Number(query.folder) || 0,
            };
        },
        routerPush() {
            this.$router.push({ query: { ...this.dataParams } });
        }
    },
    mounted() {
        this.loadParamsFromRoute();
        this.getAnimesInFolderData();
    },
    watch: {
        '$route.query': function() {
            this.loadParamsFromRoute();
            this.getAnimesInFolderData();
        }
    },
}
</script>

<template>
    <section id="TopPage">
        <div class="flex">
            <aside class="w-76 fixed top-17 left-0 flex justify-center z-10">
                <Folders @updateSelectedFolder="updateSelectedFolder"
                         :selectedFolder="this.dataParams.folder"
                />
            </aside>

            <main class="ml-76 flex-1 overflow-y-auto">
                <div class="mt-2.5 px-2.5 grid gap-2 grid-flow-row grid-cols-7">
                    <CardAnime v-if="dataLoading"
                               v-for="dataAnime in dataAnimes"
                               :id="dataAnime.id"
                               :slug="dataAnime.slug"
                               :poster="dataAnime.poster"
                               :title="dataAnime.title"
                               :rating="dataAnime.rating"
                               :episodes_released="dataAnime.episodes_released"
                               :episodes_total="dataAnime.episodes_total"
                    />

                    <CardLoading v-if="!dataLoading"
                                 v-for="n in 21"
                                 :key="n"
                    />
                </div>

                <Pagination v-if="dataAnimes"
                            :dataPagination="dataPagination"
                            @pageChange="pageChange"
                />
            </main>
        </div>
    </section>
</template>
