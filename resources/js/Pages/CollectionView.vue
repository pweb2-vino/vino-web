<template>
    <Head title="Collection" />

    <div class="bckgd">
        <main>
            <header class="column_15">
                <h1 class="title_index">{{ __('cellar.my_wines') }}</h1>
                <button class="button btn-cream">
                    <Link :href="route('wine.create')">
                        {{ __('cellar.add_custom') }}
                    </Link>
                </button>
            </header>

            <section class="column_30">           
                <div v-if="collection.length !== 0">
                    <div>
                        <ul class="wine-list">
                            <WineThumbnail  v-for="(wine, i) in collection" 
                              :key="i"
                              :wine="wine.wine"
                              :quantities="wine.quantities"
                            >
                              <!-- section std sloté -->
                              <section class="button_column_tight">
                               
                                <button class="button btn-full btn-sml btn-coral" @click="toggleModal(wine.wine)">{{ __('buttons.remove') }}</button>
                              </section>
                            </WineThumbnail>
                        </ul>
                    </div>
                </div>

                <div v-else>
                    <p class="auto_msg_no_show"><strong>{{__('dialogue.oh')}}</strong> {{ __('dialogue.no_wine') }}</p>
                </div>
            </section>
        </main>
    </div>

    <Modal v-show="openDeleteModal"
        :toggleOff="toggleModal"
    >
        <ConfirmModal
            :YesAction="delete"
            action="delete"
            :toggleModal="toggleModal"
            :actionMessage="message"
        />
    </Modal>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from "@inertiajs/inertia-vue3";
import ConfirmModal from "@/Components/ConfirmModal.vue";
import DeleteButton from "@/Components/ButtonsIcons/DeleteButton.vue";
import EditButton from "@/Components/ButtonsIcons/EditButton.vue";
import MainLayout from "@/Layouts/MainLayout.vue";
import WineThumbnail from "@/Components/WineThumbnail.vue";
import Modal from '@/Components/Modal.vue';

export default {
    name: "CollectionView",
    components: {
        ConfirmModal,
        Modal,
        DeleteButton,
        Head,
        Link,
        MainLayout,
        WineThumbnail,
        EditButton
    },
    data() {
        return {
            openDeleteModal: false,
            wineId: null,
            message: this.trans.dialogue.delete_wine,
            deleteMessage: this.trans.dialogue.wine_deleted,
        };
    },
    layout: MainLayout,
    methods: {
        toggleModal(wine) {
            this.wineId = wine;
            this.openDeleteModal = !this.openDeleteModal;
        },
        delete() {
          Inertia.delete(route("wine.delete", this.wineId), {
            onSuccess: () => {
              this.$parent.openDialog(this.deleteMessage);
            },
          });
          this.openDeleteModal = false
        },
    },
    props: ["collection", 'trans'],
};
</script>
