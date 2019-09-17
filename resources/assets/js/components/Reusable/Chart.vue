<script>
import { Line } from 'vue-chartjs' 

export default {
  props:[ "chartLoaded","user_project" ],
  extends: Line,
  data(){
    return{
      lavelArray:[],
      payment:[],
      completePayment:[],
      temp_payment:[],
    }
  },
  mounted () {
    console.log('dsfdsf', this.chartLoaded,this.user_project);
    this.prepareChartData();
    if(this.chartLoaded){
      this.printChart();
    }
  },
  methods:{

    printChart(){
      this.renderChart({
      labels: this.lavelArray,
      //labels: [1,2,3,4,5,6,7],
      datasets: [
        {
          label: 'Sales',
          backgroundColor: '#f87979',
          borderColor:'#ff33cc',
          data: this.completePayment,
        },
        {
          label: 'Revenue',
          backgroundColor: '#ccff99',
          borderColor:'#fff',
          data: this.payment,
         // data: [40, 39, 10, 40, 39, 80, 40],
				  fill: '-1'
        }
      ]
    }, {responsive: true, maintainAspectRatio: false,spanGaps: false,elements: {
				line: {
					tension: 0.000001
				}
      },
       legend: {
        padding: 100
      },
			scales: {
        yAxes: [{
          stacked: true,
          scaleLabel: {
            display: true,
            labelString: 'USD',
            fontSize:16,
            fontStyle:'bold',
          }
        }],
        xAxes: [{
          //stacked: true,
          scaleLabel: {
            display: true,
            labelString: 'Date',
            fontSize:16,
            fontStyle:'bold',
            paddig:100
          }
        }]
      }})
    },
    prepareChartData(){
      var allMonths = {"01":"31", "02":"28", "03":"31", "04":"30", "05":"31", "06":"30", "07":"31", "08":"31", "09":"30", "10":"31", "11":"30", "12":"31"};
      var dt = new Date();
      var Month_n = dt.getMonth()+1;
      var Month = '';
      if(Month_n < 10){
         Month = '0'+Month_n;
      }else{
        Month = Month_n;
      }

      for(var k=1; k<=allMonths[Month]; k++){
        this.lavelArray.push(k);
      }

      //fetching share project detail
      let mainData_share = [];
      this.user_project.forEach(element => {
        element.project_ShareImage.forEach((els_img,i)=>{
          mainData_share.push(i);
          mainData_share[i] = {
            'price': els_img.buy_amount,
            'date' : els_img.created_at
          }
        });
      });
      
      //console.log(mainData_share);

      //fetching paid project detail      
      this.lavelArray.forEach(el=>{
        let temp_data = 0;
          mainData_share.forEach(els=>{
            let day;
            if(els.date){
              day = els.date.split(' ')[0].split('-')[2]
            }else{
              day = '';
              console.log(els.date);
            }
            

            if(day == el){
              temp_data += parseFloat(els.price);

            }

          })
        this.temp_payment.push(temp_data);
      })

      
       //claculating awaited payment
      let mainData_purchase = [];
      this.user_project.forEach(element => {
        element.project_purchase.forEach((els_img,i)=>{
          mainData_purchase.push(i);
          mainData_purchase[i] = {
            'price': els_img.by_amount,
            'date' : els_img.created_at
          }
        });
      });


      //claculating payment
      this.lavelArray.forEach(el=>{
        var temp_data = 0;
          mainData_purchase.forEach(els=>{
            let day;
            if(els.date){
              day = els.date.split(' ')[0].split('-')[2]
            }else{
              day = '';
              console.log(els.date);
            }

            if(day == el){
              //console.log("el price " , parseFloat(els.price))
              temp_data += parseFloat(els.price);
            }

          })
        this.completePayment.push(temp_data);
      })

      //console.log("purches data ",this.completePayment);
      //console.log("purches data ",this.temp_payment);

      //claculating revenue
      this.temp_payment.forEach((el,i)=>{

        this.payment.push(parseFloat(el)+parseFloat(this.completePayment[i]));

      });

     //console.log("payment data ",this.payment);

    }

    
  }
}
</script>
