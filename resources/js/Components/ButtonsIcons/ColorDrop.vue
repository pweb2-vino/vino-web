<template>
  <span aria-label="color drop wine type" class="color-drop" :class="realColor">
  </span>
</template>

<script>
import { computed } from 'vue';

export default{
  name:'colorDrop',
  data () {
    return {
      realColor: computed(() => {
        if(this.color) {
          let newColor
          if(this.color.split(' ')[1] == 'wine'){
            newColor = this.color.split(' ')[0]
            switch(newColor) {
              case 'Red':
                newColor = 'rouge'
                break;
              case 'White':
                newColor = 'blanc'
                break;
              default:
                newColor = 'rouge'
                break;
            }
          } else newColor = this.color.split(' ')[1]
          if(this.color === 'Rosé ') newColor = 'rosé'
          return newColor
        }
      })
    }
  },
  props: ['color']
}
</script>
