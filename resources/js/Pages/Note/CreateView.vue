<template>
  <Head title="Cellar" />
  <main>
    <GoBackButton :color="'cream'"/>
    <header>
      <h1 class="title_index">{{ __('note.create_new') }}</h1> 
    </header>

    <form @submit.prevent="submitForm">
        <header class="column_15">
            <h2 class="typo-fs-4 typo-block-font cream"> {{ wine.name }}</h2>
            <h3 class="typo-display-font cream">{{ __('note.write_note') }}</h3>
        </header>

        <div class="form_wrapper_2">
            <label for="note" aria-labelledby="note">note</label>          
            <textarea :aria-label="__('note.write_note')" v-model="form.note" id="note" :placeholder="__('note.note_placeholder')"></textarea>
        </div>
          <InputError class="msg input_err" :message="form.errors.note" />
        <button class="button btn-cream" type="submit">{{ __('buttons.save') }}</button>
      </form>
  </main>
</template>

<script>
import { Head } from '@inertiajs/inertia-vue3';
import { useForm } from '@inertiajs/inertia-vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import GoBackButton from '@/Components/ButtonsIcons/GoBackButton.vue';
import InputError from '@/Components/InputError.vue';
import { Inertia } from '@inertiajs/inertia';

export default {
  name: 'CreateView',
  components: {
    Head,
    GoBackButton,
    MainLayout,
    InputError
  },
  data() {
    return {
      form: useForm({
        note: '',
        wine_id: this.wine.id
      }),
    };
  },
  layout: MainLayout,
  methods: {
    submitForm() {
      this.form.post(route('note.store'), {
        preserveScroll: true,
          onSuccess: () => {
            this.$parent.openDialog(`Great ! Your note has been created`);
            Inertia.visit(route('wine.show', this.wine.id))
          }
      });
    },
  },
  props: ['wine']
};
</script>
