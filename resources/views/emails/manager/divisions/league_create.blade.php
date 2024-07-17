@include('emails.partials.header')<!-- Body starts --><!--[if mso | IE]><tr><td class=""width="600px"><table border="0"cellpadding="0"cellspacing="0"align="center"class=""style="width:580px"width="580"><tr><td style="line-height:0;font-size:0;mso-line-height-rule:exactly"><![endif]--><div style="background:#fff;background-color:#fff;Margin:0 auto;max-width:580px"><table border="0"cellpadding="0"cellspacing="0"role="presentation"style="background:#fff;background-color:#fff;width:100%"align="center"><tbody><tr><td style="direction:ltr;font-size:0;padding:20px 0;text-align:center;vertical-align:top"><!--[if mso | IE]><table border="0"cellpadding="0"cellspacing="0"role="presentation"><tr><td style="vertical-align:top;width:580px"class=""><![endif]--><div style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%"class="mj-column-per-100 outlook-group-fix"><table border="0"cellpadding="0"cellspacing="0"role="presentation"style="vertical-align:top"width="100%"><tr><td style="font-size:0;padding:10px 25px;word-break:break-word"align="left"><div style="font-family:Roboto,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:18px;line-height:30px;text-align:left;color:#333">Dear {{$division->fristName}},</div></td></tr><tr><td style="font-size:0;padding:10px 25px;word-break:break-word"align="left"><div style="font-family:Roboto,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:18px;line-height:30px;text-align:left;color:#333">Congratulations on taking your first few steps into the world of Fantasy League – formed in 1991, this is the way fantasy football was meant to be played.</div></td></tr><tr><td style="font-size:0;padding:10px 25px;word-break:break-word"align="left"><div style="font-family:Roboto,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:18px;line-height:30px;text-align:left;color:#333">This is a fantasy football game like no other – the true test of management where only one team owns each player. This creates a sense of player ownership and realism that is lacking in other typical game formats.</div></td></tr><tr><td style="font-size:0;padding:10px 25px;word-break:break-word"align="left"><div style="font-family:Roboto,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:18px;line-height:30px;text-align:left;color:#333">The fun starts at the auction and continues through the season, with monthly transfer windows where you can place sealed bids for free agents against your rival managers.</div></td></tr><tr><td style="font-size:0;padding:10px 25px;word-break:break-word"align="left"><div style="font-family:Roboto,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:18px;line-height:30px;text-align:left;color:#333">With unique squads, league stay tight until the end of the season and it’s a fact that once a fantasy football fan gets involved with Fantasy League, they rarely stop.</div></td></tr><tr><td style="font-size:0;padding:10px 25px;word-break:break-word"align="left"><div style="font-family:Roboto,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:18px;line-height:30px;text-align:left;color:#333">We hope our tips for new Chairmen below will help you to guide your league into the world of Fantasy League. Once you’ve had your first taste of the auction, you'll soon find that your league will be hooked like the rest of us…</div></td></tr><tr><td style="font-size:0;padding:10px 25px;word-break:break-word"align="left"><div style="font-family:Roboto,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:18px;line-height:30px;text-align:left;color:#333">Your league details are as follows:</div></td></tr><tr><td style="font-size:0;padding:10px 25px;word-break:break-word"align="left"class="font-mono light-text"><div style="font-family:Roboto,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:18px;line-height:30px;text-align:left;color:#333">League Name: {{$division->name}}</div></td></tr><tr><td style="font-size:0;padding:10px 25px;word-break:break-word"align="left"class="font-mono light-text"><div style="font-family:Roboto,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:18px;line-height:30px;text-align:left;color:#333">To add teams, invite new managers, visit your league at <a href="{{route('manage.division.start',['division'=> $division, 'role'=> 'chairman'])}}"style="font-family:Roboto,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';color:#009b2d">{{route('manage.division.start',['division'=> $division, 'role'=> 'chairman'])}}</a>.</div></td></tr><tr><td style="font-size:0;padding:10px 25px;word-break:break-word"align="left"><div style="font-family:Roboto,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:18px;font-weight:bold;line-height:30px;text-align:left;color:#333">What makes Fantasy League different?</div></td></tr><tr><td style="font-size:0;padding:10px 25px;word-break:break-word"align="left"class="font-mono light-text"><div style="font-family:Roboto,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:18px;line-height:30px;text-align:left;color:#333">We recommend you email your prospective managers and ask them to check out the Game Guide Summary so they can start to understand what makes Fantasy League the game it is.</div></td></tr><tr><td style="font-size:0;padding:10px 25px;word-break:break-word"align="left"><div style="font-family:Roboto,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:18px;line-height:30px;text-align:left;font-weight:bold;color:#333">Holding your auction</div></td></tr><tr><td style="font-size:0;padding:10px 25px;word-break:break-word"align="left"class="font-mono light-text"><div style="font-family:Roboto,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:18px;line-height:30px;text-align:left;color:#333">The auction should be organised for a time and place that is convenient for all, most often a home, pub or club – anywhere that the group of managers can mingle and get around a table. You can hold your auction at any time, but most take place in the fortnight leading up to the Premier League's opening day. To arrange a date for your auction that all managers can make – why not try using Doodle.com - it's a nifty little tool to arrange get-togethers, or you could create a Facebook event. Remember to download your auction pack <a href="{{route('manage.division.auction.pdfdownloads',['division'=>$division])}}"style="font-family:Roboto,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';color:#009b2d">{{route('manage.division.auction.pdfdownloads',['division'=>$division])}}</a> in advance of your auction.</div></td></tr><tr><td style="font-size:0;padding:10px 25px;word-break:break-word"align="left"><div style="font-family:Roboto,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:18px;line-height:30px;text-align:left;color:#333">Even if your managers are spread far and wide, you can take advantage of the online live auction feature so to cater for remote managers.</div></td></tr><tr><td style="font-size:0;padding:10px 25px;word-break:break-word"align="left"><div style="font-family:Roboto,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:18px;line-height:30px;text-align:left;color:#333">However, if you’re pushed for a time for when everyone can get together, then you can hold your auction online using our sealed bids auction engine.</div></td></tr><tr><td style="font-size:0;padding:10px 25px;word-break:break-word"align="left"><div style="font-family:Roboto,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:18px;line-height:30px;text-align:left;font-weight:bold;color:#333">Chairing your league</div></td></tr><tr><td style="font-size:0;padding:10px 25px;word-break:break-word"align="left"><div style="font-family:Roboto,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:18px;line-height:30px;text-align:left;color:#333">Once you've held your auction, your involvement as chairman can be very little – the monthly sealed bids windows are automated.</div></td></tr><tr><td style="font-size:0;padding:10px 25px;word-break:break-word"align="left"class="font-mono light-text"><div style="font-family:Roboto,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:18px;line-height:30px;text-align:left;color:#333">Please do get in touch with us at <a href="mailto:auctionsupport@fantasyleague.com"style="font-family:Roboto,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';color:#009b2d"target="_blank">auctionsupport@fantasyleague.com</a> with any queries, or for any advice – we're always happy to help.</div></td></tr><tr><td style="font-size:0;padding:10px 25px;word-break:break-word"align="left"><div style="font-family:Roboto,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:18px;line-height:30px;text-align:left;color:#333">We look forward to welcoming you to the thrills and spills of Fantasy League!</div></td></tr></table></div><!--[if mso | IE]><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]><tr><td class=""width="600px"><table border="0"cellpadding="0"cellspacing="0"align="center"class=""style="width:580px"width="580"><tr><td style="line-height:0;font-size:0;mso-line-height-rule:exactly"><![endif]--><div style="background:#fff;background-color:#fff;Margin:0 auto;max-width:580px"><table border="0"cellpadding="0"cellspacing="0"role="presentation"style="background:#fff;background-color:#fff;width:100%"align="center"><tbody><tr><td style="direction:ltr;font-size:0;padding:20px 0;text-align:center;vertical-align:top"><!--[if mso | IE]><table border="0"cellpadding="0"cellspacing="0"role="presentation"><tr><td style="vertical-align:top;width:580px"class=""><![endif]--><div style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%"class="mj-column-per-100 outlook-group-fix"><table border="0"cellpadding="0"cellspacing="0"role="presentation"style="vertical-align:top"width="100%"><tr><td style="font-size:0;padding:10px 25px;word-break:break-word"align="left"><div style="font-family:Roboto,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:18px;line-height:30px;text-align:left;color:#333">Regards,<br>The Fantasy League team</div></td></tr></table></div><!--[if mso | IE]><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]><![endif]--><!-- Body ends --> @include('emails.partials.footer')