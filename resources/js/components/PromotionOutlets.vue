<template>
  <div class="row">
    <div class="col-md-10">
      <div class="card card-malle">
        <div class="card-header-malle">
          Promotions in Outlets
        </div>
        <div class="card-body">
          
          <form method="POST" @submit.prevent="processOutlet">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="mb-2 font-12">Mall Name</label>
                  <!-- <input type="text" name="mall_name" placeholder="Mall Name" id="mall_name" class="form-control" required=""> -->
                  <vue-bootstrap-typeahead
                    :data="malls"
                    v-model="mallsSearch"
                    :serializer="s => s.mall_name"
                    placeholder="Type a mall..."
                    @hit="fillLocation($event)"
                  ></vue-bootstrap-typeahead>
                </div>
              </div>
              
              <div class="col-md-3">
                <div class="form-group">
                  <label class="mb-2 font-12">Location</label>
                  <select name="location" id="" class="form-control" v-model="selectedLocation">
                    <template v-if="locations.length" v-for="location in locations">
                      <option :value="location.merchantlocation_id">{{ location.merchant_location }}</option>
                    </template>
                    <option v-if="!locations.length" :value="0">--- Select ----</option>
                  </select>
                </div>
              </div>
              
              <div class="col-md-3">
                <button type="submit" class="btn btn-primary col-md-12 top-t" id="btnMerchantPromotion">Update</button>
              </div>

              <div class="col-md-1">
                <div v-if="isLoading" class="spinner-border top-t" role="status">
                  <span class="sr-only">Loading...</span>
                </div>
              </div>
            </div>
          </form>
          
          <div class="row">
            <div class="col-md-12"> 
              <table class="table table-striped malle-table " id="promotion-tag-table">
                <tbody>
                  <tr v-for="outlet in outlets" class="row-promo-tags">
                    <td>{{ outlet.merchant.merchant_name }}</td>  
                    <td>
                      {{ outlet.merchant_location && outlet.merchant_location.merchant_location || null }}
                    </td>
                    <td>{{ outlet.merchant.merchant_address}}</td>  
                    <td>
                        <a href="javascript:;">
                            <span class="text-danger">Delete</span>
                        </a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
</template>

<script>
import VueBootstrapTypeahead from "vue-bootstrap-typeahead";
import _ from "lodash";

export default {
  props: ["outlets", "autocompletesrc"],

  components: {
    VueBootstrapTypeahead
  },

  mounted() {
    console.log(this.outlets);
  },

  data() {
    return {
      locations: [],
      malls: [],
      mallsSearch: "",
      selectedMall: null,
      selectedLocation: 0,
      isLoading: false
    };
  },

  watch: {
    mallsSearch: _.debounce(function(data) {
      this.getMalls(data);
    }, 500)
  },

  methods: {
    processOutlet() {},

    fillLocation(data) {
      this.selectedMall = data;
      this.locations = data.merchant_locations;
      this.selectedLocation =
        (data.merchant_locations[0] &&
          data.merchant_locations[0].merchantlocation_id) ||
        0;
    },

    async getMalls(query) {
      this.isLoading = true;

      const res = await fetch(this.autocompletesrc + "/" + query).then(
        response => {
          this.isLoading = false;
          return response;
        }
      );
      const malls = await res.json();

      this.malls = Object.values(malls);
    }
  }
};
</script>