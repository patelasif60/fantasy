@include('emails.partials.header')<!-- Body starts --><!--[if mso | IE]><tr><td class=""width="600px"><table border="0"cellpadding="0"cellspacing="0"align="center"class=""style="width:580px"width="580"><tr><td style="line-height:0;font-size:0;mso-line-height-rule:exactly"><![endif]--><div style="background:#fff;background-color:#fff;Margin:0 auto;max-width:580px"><table border="0"cellpadding="0"cellspacing="0"role="presentation"style="background:#fff;background-color:#fff;width:100%"align="center"><tbody><tr><td style="direction:ltr;font-size:0;padding:20px 0;text-align:center;vertical-align:top"><!--[if mso | IE]><table border="0"cellpadding="0"cellspacing="0"role="presentation"><tr><td style="vertical-align:top;width:580px"class=""><![endif]--><div style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%"class="mj-column-per-100 outlook-group-fix"><table border="0"cellpadding="0"cellspacing="0"role="presentation"style="vertical-align:top"width="100%"><tr><td style="font-size:0;padding:10px 25px;word-break:break-word"align="left"><div style="font-family:Roboto,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:18px;line-height:30px;text-align:left;color:#333">Dear {{$paymentDetails['user']->first_name}}{{$paymentDetails['user']->last_name}},</div></td></tr><tr><td style="font-size:0;padding:10px 25px;word-break:break-word"align="left"><div style="font-family:Roboto,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:18px;line-height:30px;text-align:left;color:#333">Thank you for your recent payment to Fantasy League.</div></td></tr><tr><td style="font-size:0;padding:10px 25px;word-break:break-word"align="left"><div style="font-family:Roboto,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:18px;line-height:30px;text-align:left;color:#333">Your payment has been securely processed. Please retain a copy of this email for your records.</div></td></tr><tr><td style="font-size:0;padding:10px 25px;word-break:break-word"align="left"><div style="font-family:Roboto,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:18px;line-height:30px;text-align:left;color:#333">The details of your purchase appear below:</div></td></tr><tr><td style="font-size:0;padding:10px 25px;word-break:break-word"align="left"><div style="font-family:Roboto,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:18px;line-height:30px;text-align:left;color:#333"><span><b>Date:</b> {{carbon_format_to_time($paymentDetails['divisionPaymentDetail']->created_at)}}</span><br><span><b>Reference:</b> {{$paymentDetails['divisionPaymentDetail']->worldpay_ordercode}}</span><br><span><b>Items:</b><br><ol>@foreach($paymentDetails['teams'] as $team) @if(count($paymentDetails['teams']) !=($paymentDetails['teams']['freeCount']+1))<li>{{$paymentDetails['division']->package->name}} package ({{$paymentDetails['division']->package->price}}) x {{count($paymentDetails['teams']) - ($paymentDetails['teams']['freeCount']+1)}} teams.</li>@endif @if($paymentDetails['division']->prize_pack)<li>{{$paymentDetails['division']->prizePack->name}} prize pack (£{{$paymentDetails['division']->prizePack->price}}) x {{count($paymentDetails['teams'])-1}} teams.</li>@endif @break @endforeach</ol></span><br><span><b>Price:</b> £{{$paymentDetails['divisionPaymentDetail']->amount}}</span></div></td></tr><tr><td style="font-size:0;padding:10px 25px;word-break:break-word"align="left"class="font-mono light-text"><div style="font-family:Roboto,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:18px;line-height:30px;text-align:left;color:#333">If you have any queries, do not hesitate to contact our customer support team at <a href="mailto:auctionsupport@fantasyleague.com"style="font-family:Roboto,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';color:#009b2d"target="_blank">auctionsupport@fantasyleague.com</a></div></td></tr></table></div><!--[if mso | IE]><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]><tr><td class=""width="600px"><table border="0"cellpadding="0"cellspacing="0"align="center"class=""style="width:580px"width="580"><tr><td style="line-height:0;font-size:0;mso-line-height-rule:exactly"><![endif]--><div style="background:#fff;background-color:#fff;Margin:0 auto;max-width:580px"><table border="0"cellpadding="0"cellspacing="0"role="presentation"style="background:#fff;background-color:#fff;width:100%"align="center"><tbody><tr><td style="direction:ltr;font-size:0;padding:20px 0;text-align:center;vertical-align:top"><!--[if mso | IE]><table border="0"cellpadding="0"cellspacing="0"role="presentation"><tr><td style="vertical-align:top;width:580px"class=""><![endif]--><div style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%"class="mj-column-per-100 outlook-group-fix"><table border="0"cellpadding="0"cellspacing="0"role="presentation"style="vertical-align:top"width="100%"><tr><td style="font-size:0;padding:10px 25px;word-break:break-word"align="left"><div style="font-family:Roboto,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:18px;line-height:30px;text-align:left;color:#333">Regards,<br>The Fantasy League team</div></td></tr></table></div><!--[if mso | IE]><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]><![endif]--><!-- Body ends --> @include('emails.partials.footer')