<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice </title>
  <style>
   @font-face {
     font-family: 'Neutra Text';
      src: url('https://host.net/fonts/Neutra2Text-Light-Lining.eot');
    }
    td{
      font-family: "Neutra Text", Verdana;
    }
        @media screen and (max-width:700px){
             td.break-col {display: block !important;width:100% !important;}
        
        }
    </style>

</head>
<body style="font-family:sans-serif;">

  <table  width="70%" style="margin:0 auto;" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>
        <table width="100%" style="border-bottom: 1px solid #ddd;">
    <tr>
      <td colspan="7" style="background: #3d2d7d;height: 30px;"></td>
    </tr>
    <tr>
      <td  style="padding-top:10px;width:700px;" valign="top">
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td>
              <img src="http://localhost/assets/img/datacuda-email-logo.jpg" alt="logo" style="width: 30%; margin-bottom: 20px;">
            </td>
          </tr>
          <tr>
            <td>
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="break-col">
              <table width="100%">
                <tr>
                  <td width="40%" style="font-weight: bold;padding-top:10px;font-size: 14px;">Address</td>
                  <td style="padding-top:10px;font-size: 14px;" width="60%">{{ $c_address }}</td>
                  </tr>
                  <tr>
                    <td width="40%" style="font-weight: bold;padding-top:10px;font-size: 14px;">City</td>
                    <td style="padding-top:10px;font-size: 14px;" width="60%">{{ $c_city }}</td>
                  </tr>
                  <tr>
                    <td width="40%" style="font-weight: bold;padding-top:10px;font-size: 14px;">State</td>
                    <td style="padding-top:10px;font-size: 14px;"width="60%">{{ $c_state }}</td>
                  </tr>
                  <tr>
                    <td width="40%" style="font-weight: bold;padding-top:10px;font-size: 14px;">Zip</td>
                    <td style="padding-top:10px;font-size: 14px;"width="60%">{{ $c_zip }}</td>
                  </tr>
                  <tr>
                     <td width="40%" style="font-size: 14px;font-weight: bold;padding-top:10px;">Country</td>
                    <td style="font-size: 14px;padding-top:10px;"width="60%">{{ $c_country }}</td>
                  </tr>
              </table>
            </td>
            <td valign="top" class="break-col">
               <table width="100%" cellspacing="0" cellpadding="0">
               <tr>
                  <td width="40%" style="font-size: 14px;font-weight: bold;padding-top:10px;">Phone</td>
                  <td style="font-size: 14px;padding-top:10px;"width="60%">{{ $c_phone }}</td>
                  </tr>
                  <tr>
                    <td width="40%" style="font-size: 14px;font-weight: bold;padding-top:10px;">Fax</td>
                    <td style="font-size: 14px;padding-top:10px;"width="60%">{{ $c_fax }}</td>
                  </tr>
                  <tr>
                    <td width="40%" style="font-size: 14px;font-weight: bold;padding-top:10px;">Email</td>
                    <td style="font-size: 14px;padding-top:10px;"width="60%">{{ $c_email }}</td>
                  </tr>
                  <tr>
                    <td width="40%" style="font-size: 14px;font-weight: bold;padding-top:10px;">Website</td>
                    <td style="font-size: 14px;padding-top:10px;"width="60%">{{ $c_website }}</td>
                  </tr>
                  
              </table>
            </td>
          </tr>
          <tr>
            <td style="height: 30px;"></td>
          </tr>
          
        </table>
      </td>
          </tr>
        </table>
        
      </td>
      
      <td colspan="3" style="text-align: right;" valign="top">
       <p style="color:#535353;font-weight: bold;">INVOICE:</p>
       <p style="color:#3d2d7d;font-weight: bold;">Invoice No: {{ $invoice_no }}</p>
       <p style="color:#535353;font-weight: bold;">{{ $date }}</p>
      </td>
    </tr>
  </table cellspacing="0" cellpadding="0">
  <table width="100%" style="margin:0 auto; " cellspacing="0" cellpadding="0" >
          <tr>
            <td style="height: 30px;"></td>
          </tr>
          
    <tr>
      <td  style="padding-top:10px;width:700px" valign="top">
        <table width="100%"  cellspacing="0" cellpadding="0">
          
          <tr>
            <td>
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td>Bill To:</td>
          </tr>
          <tr>
            <td class="break-col">
              <table width="100%" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="40%" style="font-weight: bold;padding-top:10px;font-size: 14px;">Address</td>
                  <td style="font-size: 14px;padding-top:10px;" width="60%">{{ $address }}</td>
                  </tr>
                  <tr>
                    <td width="40%" style="font-size: 14px;font-weight: bold;padding-top:10px;">City</td>
                    <td style="font-size: 14px;padding-top:10px;" width="60%">{{ $city }}</td>
                  </tr>
                  <tr>
                    <td width="40%" style="font-size: 14px;font-weight: bold;padding-top:10px;">State</td>
                    <td style="font-size: 14px;padding-top:10px;"width="60%">{{ $state }}</td>
                  </tr>
                  <tr>
                    <td width="40%" style="font-size: 14px;font-weight: bold;padding-top:10px;">Zip</td>
                    <td style="font-size: 14px;padding-top:10px;"width="60%">{{ $zip }}</td>
                  </tr>
                  <!-- <tr>
                     <td width="40%" style="font-size: 14px;font-weight: bold;padding-top:10px;">Country</td>
                    <td style="font-size: 14px;padding-top:10px;"width="60%">USA</td>
                  </tr> -->
              </table>
            </td>
            <td valign="top" class="break-col">
               <table width="100%" cellspacing="0" cellpadding="0">
                      <!-- <tr>
                        <td width="40%" style="font-size: 14px;font-weight: bold;padding-top:10px;">Phone</td>
                        <td style="font-size: 14px;padding-top:10px;"width="60%">+198324732847</td>
                      </tr>-->
                      <tr> 
                        <td width="40%" style="font-size: 14px;font-weight: bold;padding-top:10px;">Name </td>
                        <td style="font-size: 14px;padding-top:10px;"width="60%"><?php echo $buyer_name; ?></td>
                      </tr>
                      <tr>
                          <td width="40%" style="font-size: 14px;font-weight: bold;padding-top:10px;">Email</td>
                          <td style="font-size: 14px;padding-top:10px;"width="60%"><?php echo $email_id; ?></td>
                      </tr>
                      <!-- <tr>
                          <td width="40%" style="font-size: 14px;font-weight: bold;padding-top:10px;">Website</td>
                          <td style="font-size: 14px;padding-top:10px;"width="60%">datacuda.com</td>
                      </tr> -->

                           
                  
              </table>
            </td>
          </tr>
          <tr>
            <td style="height: 100px;"></td>
          </tr>
          
        </table cellspacing="0" cellpadding="0">
      </td>
          </tr>
        </table>
        
      </td>
      <td colspan="3" style="text-align: right;">
    </tr>
  </table cellspacing="0" cellpadding="0">
      </td>
    </tr>
   <!--  <tr>
      <td style="background: #88d317; height: 100px;text-align: center;color:#fff;font-size: 2em;font-weight: 600;border-bottom:10px solid #629a0e;">
        {{ $invoice_no }}
      </td>
    </tr> -->
    <tr>
     <td valign="top">
       <div style="margin-bottom: 50px;">
         <table style="margin-top: 50px;" width="100%" cellspacing="0" cellpadding="0">
          <tbody>
            <tr>
              <td width="55%" valign="top" class="break-col">
                <table style="margin-top: 50px;" width="100%" cellspacing="0" cellpadding="0">
                    <tbody>
                      <tr>
                          <td style="color:#535353;padding-bottom: 10px;">DESCRIPTION</td>
                      </tr>
                      <?php 
                        for($d=0; $d < count($description); $d++ ){
                      ?>
                      <tr>
                        <td style="color:#3d2d7d; font-size: 18px;padding-bottom: 10px;padding-top: 10px; border-bottom:1px solid #ddd;"><?php echo $description[$d]; ?></td>
                      </tr>
                     <?php }  ?>
                      <tr>
                        <td>
                          <p style="color:#bbb;font-size: 20px;">NOTE:</p>
                          <p style="color:#bbb;font-size: 16px;padding-right:20px;"><?php echo $massage; ?> </p>
                        </td>
                      </tr>
                    </tbody>
                </table>
            </td>
            <td width="45%" valign="top" class="break-col">
                <table style="margin-top: 50px;" width="100%" cellspacing="0" cellpadding="0">
                    <tbody>
                      <tr>
                          <td style="color:#535353;padding-bottom: 10px;">QUANTITY</td>
                          <td align="center" style="color:#535353;padding-bottom: 10px;">UNIT PRICE</td>
                          <td align="right" style="color:#535353;padding-bottom: 10px;">PRICE</td>
                      </tr>
                      <?php 
                        for($i=0; $i < count($amount); $i++ ){
                      ?>
                      <tr>
                          <td style="color:#3d2d7d; font-size: 18px;padding-bottom: 10px;padding-top: 10px; border-bottom:1px solid  #3d2d7d;">1</td>
                          <td align="center" style="color:#3d2d7d; font-size: 18px;padding-bottom: 10px;padding-top: 10px; border-bottom:1px solid  #3d2d7d;">$ {{ $amount[$i] }}</td>
                          <td align="right" style="color:#3d2d7d; font-size: 18px;padding-bottom: 10px;padding-top: 10px; border-bottom:1px solid  #3d2d7d;">${{ $amount[$i] }}</td>
                      </tr>
                      <?php }  ?>

                      <tr>
                          <td style="color:#3d2d7d; font-size: 18px;padding-bottom: 20px;padding-top: 20px; border-bottom:1px solid #3d2d7d;">SUBTOTAL</td>
                          <td align="center" style="color:#3d2d7d; font-size: 18px;padding-bottom: 20px;padding-top: 20px; border-bottom:1px solid #3d2d7d;"></td>
                          <td align="right" style="color:#3d2d7d; font-size: 18px;padding-bottom: 20px;padding-top: 20px; border-bottom:1px solid #3d2d7d;">${{ $buy_amount }}</td>
                      </tr>
                       <!-- <tr>
                          <td style="color:#3d2d7d; font-size: 18px;padding-bottom: 20px;padding-top: 20px; border-bottom:1px solid  #3d2d7d;">TAX</td>
                          <td align="center" style="color:#3d2d7d; font-size: 18px;padding-bottom: 20px;padding-top: 20px; border-bottom:1px solid #3d2d7d;"></td>
                          <td align="right" style="color:#3d2d7d; font-size: 18px;padding-bottom: 20px;padding-top: 20px; border-bottom:1px solid #3d2d7d;">$0.00</td>
                      </tr> -->
                       <tr>
                          <td style="color:#3d2d7d; font-size: 18px;padding-bottom: 20px;padding-top: 20px; border-bottom:1px solid #3d2d7d;">OTHER FEE</td>
                          <td align="center" style="color:#3d2d7d; font-size: 18px;padding-bottom: 20px;padding-top: 20px; border-bottom:1px solid  #3d2d7d;"></td>
                          <td align="right" style="color:#3d2d7d; font-size: 18px;padding-bottom: 20px;padding-top: 20px; border-bottom:1px solid #3d2d7d;">$0.00</td>
                      </tr>
                       <tr>
                          <td style="color:#3d2d7d; font-size: 18px;font-weight:800;padding-bottom: 20px;padding-top: 20px; border-bottom:3px solid #3d2d7d;">TOTAL</td>
                          <td align="center" style="color:#3d2d7d; font-weight:800;font-size: 18px;padding-bottom: 20px;padding-top: 20px; border-bottom:3px solid #3d2d7d;"></td>
                          <td align="right" style="color:#3d2d7d; font-weight:800;font-size: 18px;padding-bottom: 20px;padding-top: 20px; border-bottom:3px solid #3d2d7d;">${{ $buy_amount }}</td>
                      </tr>
                    
                    </tbody>
                </table>
            </td>
          </tr>
        </tbody>
      </table>
       </div>
     </td>
    </tr>
    <tr>
      <td style="background: #ece8f6; height: 100px;text-align: center;color:#000;;border-top:2px solid #431fa6;" valign="center" >
       <!-- <p style="margin:3px">If you have any questions concerning this invoice, please</p>
        <p style="margin:3px">{{ $c_phone }}</p>
        <p style="margin:3px">THANK YOU FOR YOUR BUSINESS!</p> -->
      </td>
    </tr>
  </table>
  
</body>
</html>