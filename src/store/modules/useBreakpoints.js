import { computed, ref, onMounted, onUnmounted } from 'vue';

export const useBreakpoints = () => {
  const windowWidth = ref(window.innerWidth);

  const onWidthChange = () => {
    windowWidth.value = window.innerWidth;
  };

  onMounted(() => {
    window.addEventListener('resize', onWidthChange);
  });

  onUnmounted(() => {
    window.removeEventListener('resize', onWidthChange);
  });

  const listData = {
    xs: false,
    md: false,
    lg: false
  };

  const type = computed(() => {
    if (windowWidth.value < 550) {
      listData.xs = true;
      listData.md = false;
      listData.lg = false;
    } else if (windowWidth.value >= 550 && windowWidth.value < 1265) {
      listData.xs = false;
      listData.md = true;
      listData.lg = false;
    } else if (windowWidth.value >= 1265) {
      listData.xs = false;
      listData.md = false;
      listData.lg = true;
    }
    return listData;
  });

  const width = computed(() => windowWidth.value);

  return {
    width,
    type,
    cleanup: () => {
      window.removeEventListener('resize', onWidthChange);
    }
  };
};
