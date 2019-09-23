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
                                <div style="color: #040404; font-size: 18px;"><p>Please Click on this
                                        <a href="{{ $data }}">Reset Password Link</a> and Reset Your Password</p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="margin: 0 auto; text-align: center;padding: 0 0 10px 0">
                                <div style="color: #535353; font-size: 14px;">Thanks for using DataCuda.com.<br>You will receive an email confirmation as soon as your password is updated</div>
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