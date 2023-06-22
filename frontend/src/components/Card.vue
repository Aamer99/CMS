
<template>
  <v-card class="mx-auto" width="370" style="padding: 10px;">
    <template v-slot:title> {{ type == "Departments" ? data.department.name : type == "Managers" ? data.name : data.user.name }}</template>

    <v-container>
      <v-row no-gutters>
        <v-col>
          <v-row no-gutters align="center">
            <v-col cols="2">
              <img src="../assets/icons/requests.png" class="w-10 h-10"/>

            </v-col>

            <v-col cols="10">
              <v-container>
                <v-row no-gutters align="center">
                  <p class="font-weight-black text-lg">12</p>
                </v-row>
                <v-row align="center">
                  <p class="font-weight-thin">Requests</p>
                </v-row>
              </v-container>

            </v-col>
          </v-row>
        </v-col>

       
        <v-col v-show="this.type == 'Departments'">
          <v-row no-gutters align="center">
            <v-col cols="2">
              <img src="../assets/icons/employees.png" class="w-10 h-10"/>

            </v-col>

            <v-col cols="10">
              <v-container>
                <v-row no-gutters align="center">
                  <p class="font-weight-black text-lg">12</p>
                </v-row>
                <v-row align="center">
                  <p class="font-weight-thin">Employees</p>
                </v-row>
              </v-container>

            </v-col>
          </v-row>
        </v-col>
      </v-row>

      <v-row no-gutters>
        <v-col cols="12">
          <Bar id="my-chart-id" :options="chartOptions" :data="chartData" />
        </v-col>
      </v-row>
    </v-container>
  </v-card>
</template>

<script>
import { Bar } from "vue-chartjs";
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
} from "chart.js";
ChartJS.register(
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale
);

export default {
  name: "BarChart",
  components: { Bar },
  props:["type","data"],
  data() {
    return {
      chartData: {
        labels: ["January", "February", "March"],
        datasets: [{ data: [40, 20, 12],backgroundColor:["red","green","blue"] }],
        backgroundColor: "red"
      },
      chartOptions: {
        responsive: true,
      },
    };
  },
 
};
</script>