<template>
    <Head title="Add Wine to List" />

    <div class="bckgd bckgd-burg">

        <main class="main-default">
            <GoBackButton :color="'cream'"/>

            <header>
                <h1 class="typo-fs-3 typo-block-font coral">{{ __('cellar.add_buylist') }}</h1>
            </header>

            <form @submit.prevent="addToBuyList" class="form-quantity">
                <h2 class="fiche_wine_title">{{ wineData.name }}</h2>
                
                <section>
                    <figure><img :src="wineData.photo" :alt="wineData.name"></figure>

                    <div>
                        <label for="quantity"></label>
                        <input type="number" id="quantity" v-model="form.quantity">
                        <InputError class="auto_msg auto_msg_input_err" :message="form.errors.quantity" />

                        <div>
                            <MinusButton :color="'burgundy'" :removeAction="removeOne" />
                            <PlusButton :color="'burgundy'" :addAction="addOne" />
                        </div>
                    </div>
                </section>

                <section>
                    <button class="button btn-burgundy">{{ __('buttons.add') }}</button>
                </section>
            </form>
        </main>
    </div>
</template>

<script>
import { useForm, Link, Head } from '@inertiajs/inertia-vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import PlusButton from '@/Components/ButtonsIcons/PlusButton.vue';
import MinusButton from '@/Components/ButtonsIcons/MinusButton.vue';
import GoBackButton from '@/Components/ButtonsIcons/GoBackButton.vue';
import InputError from '@/Components/InputError.vue';

export default {
  name: 'AddForm',
  components: {
    Link,
    Head,
    PlusButton,
    MinusButton,
    GoBackButton,
    InputError
  },
  data() {
    return {
      showDialog: false,
      message: '',
      showForm: false,
      selectedWine: '',
      form: useForm({
        wine_id: this.wineData.id,
        quantity: '1'
      })
    }
  },
  layout: MainLayout,
  methods: {
    addToBuyList() {
      this.form.post(route('buylist.store'), {
        onSuccess: () => {
          this.$parent.openDialog(
            `Yeah! You just added ${this.form.quantity} bottle${this.form.quantity > 1 ? 's' : ''} to you shopping list`
          )
          this.closeForm()
        }
      })
    },
    closeForm() {
      this.showForm = false
      this.form.reset()
    },
    openForm(id) {
      this.form.reset()
      this.showForm = true
    },
    addOne() {
      this.form.quantity++
    },
    removeOne() {
      if (this.form.quantity > 1) this.form.quantity--
    }
  },
  props: ['wineData']
}
</script>