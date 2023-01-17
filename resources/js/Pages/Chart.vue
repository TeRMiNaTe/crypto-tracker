<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import { computed } from 'vue';

const props = defineProps({
    tickerData: Array,
    tickerSymbol: String,
    status: String,
});

const form = useForm({
    symbol: props.tickerSymbol,
    price: '',
    email: '',
});

const submit = () => {
    form.post(route('create-alert'));
};

var alertCreated = computed(() => props.status === 'alert-created');
</script>

<template>
    <Head title="Welcome" />

    <div
        class="relative flex items-top justify-center min-h-screen bg-gray-100 sm:items-center sm:pt-0"
    >
        <div class="w-full max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="justify-center pt-8 sm:pt-0">
              <div class="mt-2 text-gray-600">
                  <Line :data="data" :options="options" :tickerData="tickerData"/>
              </div>

              <div class="mt-5 text-gray-600 text-sm">
                  Get notified when the price of {{tickerSymbol}} goes above a given threshold
              </div>

              <form @submit.prevent="submit" class="mt-2">
                  <div>
                      <InputLabel for="price" value="Price" />

                      <TextInput
                          id="price"
                          type="text"
                          class="mt-2 block w-full"
                          v-model="form.price"
                          required
                          autofocus
                      />

                      <InputError class="mt-2" :message="form.errors.price" />
                  </div>
                  <div>
                      <InputLabel for="email" value="Email" />

                      <TextInput
                          id="email"
                          type="email"
                          class="mt-2 block w-full"
                          v-model="form.email"
                          required
                      />

                      <InputError class="mt-2" :message="form.errors.email" />
                  </div>

                  <div class="flex items-center mt-4">
                      <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                          Create alert
                      </PrimaryButton>
                  </div>
              </form>

              <div class="ml-4 font-medium text-sm text-green-600" v-if="alertCreated">
                  A new price alert has been created.
              </div>
            </div>
        </div>
    </div>
</template>

<script>
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend,
  TimeScale
} from 'chart.js'
import { Line } from 'vue-chartjs'
import 'chartjs-adapter-moment';

ChartJS.register(CategoryScale, LinearScale, PointElement, LineElement, Title, Tooltip, Legend, TimeScale)

export default {
  name: 'App',
  props: ['tickerData'],
  components: {
    Line
  },
  data() {
    return {
      data: {
        datasets: [
          {
            label: this.tickerSymbol+' Price',
            data: this.tickerData
          }
        ]
      },
      options: {
        responsive: true,
        parsing: {
          xAxisKey: 'updated_at',
          yAxisKey: 'price'
        },
        scales: {
          x: {
              type: 'time',
              time: {
                  unit: 'minute'
              }
          }
        }
      }
    }
  }
}
</script>
