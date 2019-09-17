<template>
<div class="alertData" id="notice_data" >
   <div class="dropdown">
  <button class="dropbtn"><img src="/assets/img/alarm.png" alt="notifications" ><span v-if="notificationCount > 0">{{notificationCount}} </span></button>
  <div class="dropdown-content notification-list-wrapper"  v-if="notificationCount > 0" >
    <div class="clearAllWrapper"><button class="btn clearAll" v-on:click="delNoticalear" >Clear all</button></div>
   <ul v-for="list in lists" class="notication-list">
        <!-- <li v-on:click="show_notification_popUp()">{{ list.noticealerts.message }}</li> -->
         <li v-on:click="show_notification_popUp(list.noticealerts.title,list.noticealerts.message)"><a href="javascript:void(0)"><div class="noti_subject" >{{ list.noticealerts.title }} </div> <!-- <div class="noti_body"> {{ list.noticealerts.message }}</div>---></a></li>
  </ul>
      
  </div>
    
</div>
			<!-- <flash-message class="myCustomClass"></flash-message> -->

<div class="modal" id="nofication-popup" name="ask_for_password">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header" style="border-bottom:none;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

          <!-- Modal body -->
          <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10 form_content_box">
              <div class="form_logo"><img src="../../../img/datacuda.png"></div>
              <flash-message class="myCustomClass"></flash-message>
              <h2 class="text-center">{{noti_sub}}</h2>
              <p class="text-center" style="color:#431fa6;"> {{ noti_msg }}</p>
            </div>
            <div class="col-md-1"></div>
          </div>

          <!-- Modal footer -->
          <!-- <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div> -->

        </div>
      </div>
    </div>


</div>





</template>




<script>
export default {
  data() {
    return {
      notificationCount: "",
      lists: [],
      noticeData: [],
      noti_sub:'',
      noti_msg:'',
      interval: undefined,
      authenticated: auth.check(),
        user: auth.user,
    };
  },
  methods: {
    delNoticalear(){
       axios
        .get("api/de_notice")
        .then(response => {
          this.get_notice();
          this.get_list_of_notification();
          console.log("Deleted Successfully");
        })
        .catch(response => {
          console.log("Delete Failed");
        });
    },
    get_notice() {
      axios
        .get("api/count_notice")
        .then(response => {
          this.notificationCount = response.data.data.count;
          // if( this.notificationCount>0)
          // this.flash('You have a new notification!', 'success');
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
    },
     show_notification_popUp(sub,msg) {
        //this.$modal.show("payment_modal");
        this.noti_sub = sub;
        this.noti_msg = msg;    
         $("#nofication-popup").modal()
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