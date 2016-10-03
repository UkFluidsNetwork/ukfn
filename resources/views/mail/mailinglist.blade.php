{!! $body !!}
<br><br><br><br>
<p class="text-muted" style='font-size:12px;'>
  {{ Html::link($unsubscribe, 'Unsubscribe') }} | Contact Us: {{ Html::link('mailto:info@ukfluids.net', 'info@ukfluids.net') }} <br><br>
  You are receiving this email because {{ Html::link('mailto:' . $address, $address) }} is registered in UKFN's mailing list.
</p>