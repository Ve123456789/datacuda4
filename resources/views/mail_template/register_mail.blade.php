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
                                <a  href="mailto:"{{ $email_id }} style="text-decoration: none; color: #3d2d7d; font-size: 18px; font-weight: 600; display: inline-block">Hello, {{ $data['username'] }}</a>
                            </td>
                        </tr>
                        <tr>
                            <td  style="margin: 0 auto; padding: 15px; text-align: center">
                                 <div style="color: #1a0315;font-size: 16px; font-weight: 600">
                                    <p>Please verify your email address. <a href="{{ $data['link'] }}">Verify </a> Please let us know if you run into any issues activating your account.</p>

                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td  style="margin: 0 auto; padding: 15px; text-align: center">

                                <div style="color: #040404; font-size: 22px;">
                                    <p>
                                      Thank you,DataCuda
                                    </p>
                                </div>
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