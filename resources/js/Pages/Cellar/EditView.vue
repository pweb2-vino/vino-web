<template>
  <Head title="Edit Cellar" />

  <main>
    <GoBackButton :color="'cream'" />

    <header>
      <h1 class="title_index">{{ __('cellar.edit') }}</h1>
    </header>

    <form @submit.prevent="submitForm">
      <h2 class="title_disp_subt">{{ __('cellar.modify_text') }}</h2>

      <div class="form_wrapper_2">
        <label for="name">{{ __('cellar.name') }}</label>
        <input v-model="form.name" type="text" id="name" required>
        <InputError class="auto_msg auto_msg_input_err" :message="form.errors.name" />
      </div>

      <button class="button btn-cream" type="submit">{{ __('buttons.save') }}</button>
    </form>
  </main>
</template>
  
<script>
import { Head, useForm } from '@inertiajs/inertia-vue3';
import GoBackButton from '@/Components/ButtonsIcons/GoBackButton.vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import InputError from '@/Components/InputError.vue';

export default {
  name: 'EditView',
  components: {
    Head,
    GoBackButton,
    InputError
  },
  props: {
    cellar: {
      type: Object,
    }
  },
  layout: MainLayout,
  data() {
    return {
      form: useForm({
        id: this.cellar.id,
        name: this.cellar.name,
      })
    };
  },
  methods: {
    submitForm() {
      this.form.put(route('cellar.update', { cellar: this.form.id }), {
        onSuccess: () => {
          this.$parent.openDialog(this.__('dialogue.cellar_update'));
        },
      });
    },
  },
};
</script>
