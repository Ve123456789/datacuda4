<div>
    <font face="Open Sans">
        <tbody>
            <tr>
                <td>
                    <table style="border-collapse:collapse; border-spacing:0; width:600px; background-color:#f1f1f1; margin:0 auto; border-width:600px; max-width:600px" width="600" border="0">
                        <tbody>
                            <tr>
                               <td><img src="{{url('assets/email_download_files/emailer_header_bg.png')}}" style="width:100%"> </td>
                            </tr>
                        </tbody>
                    </table>
                    <table style="border-collapse:collapse; border-spacing:0; width:600px; background-color:#fff; margin:0 auto; border-width:600px; max-width:600px" width="600" border="0">
                        <tbody>
                            <tr>
                                <td style="margin:0 auto; text-align:center"><img src="{{url('assets/email_download_files/rectangle.png')}}" style="width:auto; padding:25px 0px 10px 0px"> </td>
                            </tr>                       
                            <tr>
                                <td style="margin:0 auto; text-align:center;font-size:20px;font-weight:bold;color:#6c1084;padding-bottom:5px;">{{ $media_details['client_mail'] }}</td>
                            </tr>
                            <tr>
                                <td style="margin:0 auto; text-align:center;font-size:20px;font-weight:bold;">has paid you for their files. You received (${{ $media_details['total_amount'] }})</td>
                            </tr>
                            <tr>
                                <td style="margin:0 auto; text-align:center;padding-top:20px;color:#948e8e;">{{ $media_details['file_count'] }} files, {{ $media_details['total_size'] }} MB</td>
                            </tr>
                            <tr>
                                <td style="margin:0 auto; text-align:center;padding-bottom:20px;color:#948e8e;">Will be deleted on {{ $media_details['delete'] }}</td>
                            </tr>
                            <tr>
                                <td style="margin:0 auto; text-align:center; padding:0 0 10px 0">
                                <div style="color:#535353; font-size:14px">Thanks for using DataCuda.com.<br>
                                You will receive an email confirmation as soon as your files have been downloaded</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table style="border-collapse:collapse; border-spacing:0; width:600px; background-color:#fff; margin:0 auto; border-width:600px; max-width:600px" width="600" border="0">
                        <tbody>
                            <!-- <tr>
                                <td style="margin:0 auto; padding:30px 60px 0 60px">
                                <div style="color:#1a0315; font-size:16px; font-weight:600">Download Link</div>
                                </td>
                            </tr>

                            <tr>
                                <td style="margin:0 auto; padding:5px 60px 0 60px">
                                <div style="color:#3d2d7d; font-size:16px; font-weight:600">{{ $data }}</div>
                                </td>
                            </tr> -->
                            <tr>
                                <td style="margin:0 auto; padding:20px 60px 0 60px">
                                <div style="color:#1a0315; font-size:16px; font-weight:600">{{ $media_details['file_count'] }} files</div>
                                </td>
                            </tr>
                            <tr>
                                <td style="margin:0 auto; padding:10px 60px 0 60px">
                                <?php foreach ($media_details['medias'] as $media) { ?>
                                    <div style="color: #535353; font-size: 14px; padding: 5px 0px"> {{ $media->filename }}</div>
                                <?php } ?>
                                </td>
                            </tr>
                            

                        </tbody>
                    </table>
                    <table style="border-collapse:collapse; border-spacing:0; width:600px; margin:0 auto; border-width:0; max-width:600px; background:#fff" width="600">
                        <tbody>
                            <tr>
                                <td>
                                <div style="color:#535353; font-weight:600; font-size:16px;text-align:left;padding: 10px 60px 5px 0px">
                                Message</div>
                                </td>
                            </tr>
                             <tr>
                                <td>
                               <!--  <div style="color:#9c989b; font-weight:500; font-size:16px; padding:15px 20px 0px 0px; text-align:left">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy</div> -->
                                </td>
                            </tr>
                            <tr>
                                <td>
                                <div style="color:#535353; font-weight:300; font-size:14px; padding:30px 0px 15px 0px; text-align:center">
                                To make sure our emails arrive, please add noreply@datacuda.com to your contacts</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table style="border-collapse:collapse; border-spacing:0; width:600px; margin:0 auto; border-width:0; max-width:600px; background:#dcdcdc" width="600">
                        <tbody>
                            <tr>
                                <td>
                                <div style="color:#535353; font-size:14px; padding:30px 0px 5px 0px; text-align:center">
                                Get more out of <a href="#" style="text-decoration:underline; font-weight:600; color:#535353; font-size:14px; font-family:'Lato'; display:inline-block">DataCuda.com</a></div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                <div style="color:#535353; font-size:14px; padding:0px 10px 30px 0px; text-align:center">
                                Get a <a href="#" style="text-decoration:underline; font-weight:600; color:#3d2d7d; font-size:14px; font-family:'Lato'; display:inline-block">Pro Plan</a></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    </font>
</div>