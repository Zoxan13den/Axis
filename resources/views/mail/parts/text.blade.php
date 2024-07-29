<tr class="tr-body">

    <td align="center">

        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#ffffff"
               style="margin: 0; padding: 0;">

            <tr>
                <td height="1" bgcolor="#676767" class="line"></td>
            </tr>

            <tr>

                <td align="center" bgcolor="#ffffff"
                    style="padding-bottom: 20px; padding-left: 20px; padding-right: 20px; padding-top: 20px;">

                        <p style="color: black; font-size: 16px; line-height: 1.3; margin-bottom: 0; margin-top: 0; padding-bottom: 0; padding-top: 0;">
                            {!! $text !!}
                        </p>

                        @isset($message_text)
                            <p>
                                {!! $message_text !!}
                            </p>
                        @endisset

                </td>

            </tr>

        </table>

    </td>
</tr>