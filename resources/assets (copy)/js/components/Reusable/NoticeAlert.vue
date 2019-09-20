<template>
<div class="alertData" id="notice_data" >
   <div class="dropdown">
  <button class="dropbtn"><img src="/assets/img/alarm.png" alt="notifications" ><span v-if="notificationCount > 0">{{notificationCount}} </span></button>
  <div class="dropdown-content"  v-if="notificationCount > 0">
   <ul v-for="list in lists">
        <li><router-link :to="'/noticeDetail/' +list.noticealerts.id">{{ list.noticealerts.title | uppercase }}:{{ list.noticealerts.message }}</router-link></li>
  </ul>
      
  </div>
    
</div>
			<!-- <flash-message class="myCustomClass"></flash-message> -->

</div>
</template>

<script>
export default {
  data() {
    return {
      notificationCount: "",
      lists: [],
      noticeData: [],
      interval: undefined,
      authenticated: auth.check(),
        user: auth.user,
    };
  },
  methods: {
    get_notice() {
      axios
        .get("api/count_notice")
        .then(response => {
          this.notificationCount = response.data.data.count;
          if( this.notificationCount>0)
          this.flash('You have a new notification!', 'success');
        })
        .catch(response => {
         // console.log(response);
        });
    },
    get_list_of_notification() {
      axios
        .get("api/notice_list")
        .then(response => {
          this.lists = response.data.data;
          //console.log(lists);
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
  created() {
    this.get_notice();
    this.get_list_of_notification();
    // this.viewData();
    this.interval = setInterval(() => {
      this.get_notice();
      this.get_list_of_notification();
    }, 10000);
  }
};
</script>