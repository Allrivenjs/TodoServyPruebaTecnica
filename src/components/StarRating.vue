<template>
  <div class="flex gap-x-2 items-end justify-center">
    {{ reviews_count !== undefined ? '('+reviews_count+')' : '' }}
    <star-rating
        @click="$emit('rating-selected', onRatingSelected)"
        :rating="itemRating"
        :read-only="readOnly"
        :star-size="20"
        :increment="1"
        :show-rating="!readOnly"
    />

  </div>
</template>

<script setup>
import StarRating from 'vue-star-rating'

defineProps({
  itemRating: {
    type: Number,
    required: false,
    default: 1
  },
  reviews_count: {
    type: Number,
    required: false,
  },
  readOnly: {
    type: Boolean,
    required: false,
    default: true,
  },


})


function onRatingSelected() {
  return document.getElementsByClassName('vue-star-rating-rating-text')[0].textContent
}
</script>
