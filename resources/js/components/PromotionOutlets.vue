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
                  <vue-bootstrap-typeahead
                    :data="malls"
                    v-model="mallsSearch"
                    :serializer="s => s.mall_name"
                    placeholder="Type a mall..."
                    @hit="fillLocation($event)"
                    :minMatchingChars="1"
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
                  <tr v-for="outlet in dataOutlets" class="row-promo-tags">
                    <td>{{ outlet.mall && outlet.mall.mall_name || null }}</td>  
                    <td>
                      {{ outlet.merchant_location && outlet.merchant_location.merchant_location || null }}
                    </td>
                    <td>{{ outlet.merchant_location && outlet.merchant_location.floor.level || null}}</td>  
                    <td>
                      <a href="javascript:;" class="btn-edit"><span class="text-success">Edit</span></a>
                    </td>
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
  props: ["promoId", "outlets", "autocompletesrc", "postUrl"],

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
      isLoading: false,
      dataOutlets: this.outlets
    };
  },

  watch: {
    mallsSearch: _.debounce(function(data) {
      this.getMalls(data);
    }, 500)
  },

  methods: {
    processOutlet() {
      if (this.selectedMall) {
        axios
          .post(this.postUrl, {
            merchantlocation_id: this.selectedLocation,
            mall_id: this.selectedMall.mall_id,
            promo_id: this.promoId
          })
          .then(response => {
            toastr.success("Successfully Added!");
            console.log(response);
            this.dataOutlets.push(response.data);
          });
      }
    },

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