<div>
    <font face="Open Sans">
        <table width="600" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border-spacing:0;text-indent:0;text-align:left;background-color:#F8F9FA;margin:0 auto;border-width:0;white-space:normal; width: 600px; max-width:600px; border: 1px solid #f7f7f7">
            <tbody>
            <tr>
                <td>
                    <table width="600" border="0" style="border-collapse:collapse;border-spacing:0;width:600px;background-color:#f1f1f1;margin:0 auto;border-width:600px;max-width:600px;">
                        <tbody>
                        <tr>
                            <td>
                                <img src="{{url('assets/email_download_files/emailer_header_bg.png')}}" style="width: 100%">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <table width="600" border="0" style="border-collapse:collapse;border-spacing:0;width:600px;background-color:#fff;margin:0 auto;border-width:600px;max-width:600px;">
                        <tbody>
                        <tr>
                            <td  style="margin: 0 auto; text-align: center">
                                <img src="{{url('assets/email_download_files/rectangle.png')}}" style="width: auto; padding: 25px 0px 20px 0px">
                            </td>
                        </tr>
                        <tr>
                            <td  style="margin: 0 auto; text-align: center">
                                <a  href="mailto:" style="text-decoration: none; color: #3d2d7d; font-size: 18px; font-weight: 600; display: inline-block">{{ $email_id }}</a>
                            </td>
                        </tr>
                        <tr>
                            <td  style="margin: 0 auto; padding: 15px; text-align: center">
                                <div style="color: #040404; font-size: 18px;">Download your Image</div>
                            </td>
                        </tr>
                        <tr>
                            <td  style="margin: 0 auto; text-align: center">
                                <div style="color: #535353; font-size: 14px;">{{ $media_details['file_count'] }} files, 72.5 KB</div>
                            </td>
                        </tr>
                        <tr>
                            <td style="margin: 0 auto; text-align: center;padding: 15px">
                                <div style="color: #535353; font-size: 14px;">Will be deleted on September 20, 2017</div>
                            </td>
                        </tr>
                        <tr>
                            <td style="margin: 0 auto; text-align: center;padding: 0 0 10px 0">
                                <div style="color: #535353; font-size: 14px;">Thanks for using DataCuda.com.<br>You will receive an email confirmation as soon as your files have been downloaded</div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <table width="600" border="0" style="border-collapse:collapse;border-spacing:0;width:600px;background-color:#fff;margin:0 auto;border-width:600px;max-width:600px;">
                        <tr>
                            <td style="margin: 0 auto; padding: 30px 60px 0 60px">
                                <div style="color: #1a0315;font-size: 16px; font-weight: 600">Sent to</div>
                            </td>
                        </tr>
                        <tr>
                            <td style="margin: 0 auto; padding: 0 60px 0 60px">
                                <div style="color: #3d2d7d; font-size: 14px; padding: 10px 0px">{{ $email_id }}</div>
                            </td>
                        </tr>
                        <tr>
                            <td style="margin: 0 auto; padding: 20px 60px 0 60px">
                                <div style="color: #1a0315;font-size: 16px; font-weight: 600">
                                    <p>Please view your files here <a href="{{ $data }}">View Image </a> and click on buy now to download them</p>

                                </div>
                            </td>
                        </tr>
                        {{--<tr>--}}
                            {{--<td style="margin: 0 auto; padding: 0 60px 10px 60px">--}}
                                {{--<a href="{{ $data }}" style="text-decoration: underline; color: #1a0315; font-size: 12px; display: inline-block">{{ $data }}</a>--}}
                            {{--</td>--}}
                        {{--</tr>--}}
                        <tr>
                            <td style="margin: 0 auto; padding: 15px 60px 0 60px">
                                <div style="color: #1a0315;font-size: 14px; font-weight: 600">{{ $media_details['file_count'] }} files</div>
                            </td>
                        </tr>
                        <tr>
                            <td style="margin: 0 auto; padding: 0 60px 0 60px">
                                <?php foreach ($media_details['medias'] as $media) { ?>
                                    <div style="color: #535353; font-size: 14px; padding: 5px 0px"> {{ $media->filename }}</div>
                                <?php } ?>
                            </td>
                        </tr>
                    </table>
                    <table width="600" style="border-collapse:collapse;border-spacing:0;width:600px;margin:0 auto;border-width:0;max-width:600px; background:#fff; ">
                        <tbody>
                        <tr>
                            <td>
                                <div style="color: #535353; font-weight: 300; font-size: 14px; padding: 30px 0px 15px 0px; text-align: center">To make sure our emails arrive, please add noreply@datacuda.com to your contacts</div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <table width="600" style="border-collapse:collapse;border-spacing:0;width:600px;margin:0 auto;border-width:0;max-width:600px; background: #dcdcdc;">
                        <tbody>
                        <tr>
                            <td>
                                <div style="color: #535353; font-size: 14px; padding: 30px 0px 5px 0px; text-align: center ">Get more out of <a href="#" style="text-decoration: underline; font-weight: 600; color: #535353; font-size: 14px; font-family: 'Lato'; display: inline-block">DataCuda.com</a></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="color: #535353; font-size: 14px; padding: 0px 10px 30px 0px; text-align: center ">Get a <a href="#" style="text-decoration: underline; font-weight: 600; color: #3d2d7d; font-size: 14px; font-family: 'Lato'; display: inline-block">Pro Plan</a></div>
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