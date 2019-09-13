<template>
<section class="payments_wrapper white_bg">
        <div class="container">
             <h2 class="text-center"><strong> {{ noticeData.title |  uppercase}}</strong></h2>
            <p> {{ noticeData.message | uppercase}}  </p>       
        </div>
    </section>
</template>

<script>
export default {
  data() {
    return {
      noticeData: []
    };
  },
  methods: {
    viewData(id) {
      axios
        .get("api/get_notice_by_id/" + this.$route.params.id)
        .then(response => {
          this.noticeData = response.data.data;
        })
        .catch(response => {
         // console.log(response);
        });
    },
    readNotification(id) {
      axios
        .get("api/del_notice/" + this.$route.params.id)
        .then(response => {
         // console.log(response);
        })
        .catch(response => {
          //console.log(response);
        });
    }
  },
  filters: {
    uppercase: function(string) {
      return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
    }
  },
  mounted: function() {
    this.readNotification();
  },
  created() {
    this.viewData();
    this.readNotification();
  }
};
</script>