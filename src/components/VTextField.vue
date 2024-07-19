<template>
  <v-text-field v-bind="textFieldProps" :value="modelValue" @input="$emit('update:modelValue', $event)"></v-text-field>
</template>

<script>
export default {
  name: 'VTextField',
  props: {
    modelValue: {
      type: [String, Number],
      default: '',
    },
    label: {
      type: String,
      default: '',
    },
    type: {
      type: String,
      default: 'text',
    },
    errorMessages: {
      type: Array,
      default: () => [],
    },
    required: {
      type: Boolean,
      default: false,
    },
    appendIcon: {
      type: String,
      default: '',
    },
    prependIcon: {
      type: String,
      default: '',
    },
    counter: {
      type: Boolean,
      default: false,
    },
    name: {
      type: String,
      default: '',
    },
  },
  computed: {
    textFieldProps() {
      return {
        label: this.label,
        type: this.type,
        errorMessages: this.errorMessages,
        required: this.required,
        appendIcon: this.appendIcon,
        prependIcon: this.prependIcon,
        counter: this.counter,
        name: this.name,
      };
    },
  },
};
</script>
