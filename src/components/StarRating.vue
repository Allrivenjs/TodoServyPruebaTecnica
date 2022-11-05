<template>
  <div class="flex gap-x-2 items-end justify-center">
    ({{reviews_count}})
    <star-rating
        :rating="itemRating"
        :read-only="true"
        :star-size="20"
        :rtl="true"
        :increment="0.5"
        :show-rating="false"
    />
  </div>
</template>

<script setup>
import StarRating from 'vue-star-rating'
defineProps({
  itemRating: {
    type: Number,
    required: true,
  },
  reviews_count: {
    type: Number,
    required: true,
  },
})
</script>
