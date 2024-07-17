@include('emails.partials.header')<!-- Body starts --><!--[if mso | IE]><tr><td class=""width="600px"><table border="0"cellpadding="0"cellspacing="0"align="center"class=""style="width:580px"width="580"><tr><td style="line-height:0;font-size:0;mso-line-height-rule:exactly"><![endif]--><div style="background:#fff;background-color:#fff;Margin:0 auto;max-width:580px"><table border="0"cellpadding="0"cellspacing="0"role="presentation"style="background:#fff;background-color:#fff;width:100%"align="center"><tbody><tr><td style="direction:ltr;font-size:0;padding:20px 0;text-align:center;vertical-align:top"><!--[if mso | IE]><table border="0"cellpadding="0"cellspacing="0"role="presentation"><tr><td style="vertical-align:top;width:580px"class=""><![endif]--><div style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%"class="mj-column-per-100 outlook-group-fix"><table border="0"cellpadding="0"cellspacing="0"role="presentation"style="vertical-align:top"width="100%"><tr><td style="font-size:0;padding:10px 25px;word-break:break-word"align="left"><div style="font-family:Roboto,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:18px;line-height:30px;text-align:left;color:#333">Dear {{$emailDetails['first_name']}},</div></td></tr><tr><td style="font-size:0;padding:10px 25px;word-break:break-word"align="left"><div style="font-family:Roboto,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:18px;line-height:30px;text-align:left;color:#333">Congratulations! Your Fantasy League sealed bids auction has now been completed and your league is all set for the season ahead.</div></td></tr><tr><td style="font-size:0;padding:10px 25px;word-break:break-word"align="left"><div style="font-family:Roboto,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:18px;line-height:30px;text-align:left;color:#333">Please visit your <a href="{{$emailDetails['league_link']}}"style="font-family:Roboto,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';color:#009b2d">league</a> page and remember to set your team line-up for all the forthcoming fixtures.</div></td></tr><tr><td style="font-size:0;padding:10px 25px;word-break:break-word"align="left"><div style="font-family:Roboto,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:18px;line-height:30px;text-align:left;color:#333">Be lucky!</div></td></tr></table></div><!--[if mso | IE]><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]><tr><td class=""width="600px"><table border="0"cellpadding="0"cellspacing="0"align="center"class=""style="width:580px"width="580"><tr><td style="line-height:0;font-size:0;mso-line-height-rule:exactly"><![endif]--><div style="background:#fff;background-color:#fff;Margin:0 auto;max-width:580px"><table border="0"cellpadding="0"cellspacing="0"role="presentation"style="background:#fff;background-color:#fff;width:100%"align="center"><tbody><tr><td style="direction:ltr;font-size:0;padding:20px 0;text-align:center;vertical-align:top"><!--[if mso | IE]><table border="0"cellpadding="0"cellspacing="0"role="presentation"><tr><td style="vertical-align:top;width:580px"class=""><![endif]--><div style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%"class="mj-column-per-100 outlook-group-fix"><table border="0"cellpadding="0"cellspacing="0"role="presentation"style="vertical-align:top"width="100%"><tr><td style="font-size:0;padding:10px 25px;word-break:break-word"align="left"><div style="font-family:Roboto,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:18px;line-height:30px;text-align:left;color:#333">Regards,<br>The Fantasy League team</div></td></tr></table></div><!--[if mso | IE]><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]><![endif]--><!-- Body ends --> @include('emails.partials.footer')