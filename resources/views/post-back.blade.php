{{-- resources/views/hotspot/post-back.blade.php --}}
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Completing login…</title>

  {{-- Anti-cache supaya browser tidak menyimpan halaman lama --}}
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">

  <style>
    /* sederhana — supaya user melihat pesan singkat bila JS dimatikan */
    body { font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; background:#f8fafc; color:#111827; display:flex; align-items:center; justify-content:center; height:100vh; margin:0; }
    .card { background:#fff; padding:16px; border-radius:10px; box-shadow:0 6px 20px rgba(2,6,23,0.08); text-align:center; width:90%; max-width:420px; }
    .muted { color:#6b7280; font-size:0.95rem; }
  </style>
</head>
<body>
  <div class="card" aria-live="polite">
    <h3>Completing login…</h3>
    <p class="muted">You will be redirected momentarily to finish your connection.</p>

    {{-- FORM yang akan di-submit ke MikroTik (tidak menggunakan @csrf) --}}
    <form id="uam_post_form" method="post" action="{{ $link }}">
      {{-- Pastikan variabel sudah tersedia dan di-escape --}}
      <input type="hidden" name="username" value="{{ e($username) }}">
      <input type="hidden" name="password" value="{{ e($password) }}">
      @if(!empty($ip))
        <input type="hidden" name="ip" value="{{ e($ip) }}">
      @endif
      @if(!empty($mac))
        <input type="hidden" name="mac" value="{{ e($mac) }}">
      @endif
      {{-- Beberapa router mungkin butuh field tambahan (user-agent, dst). Tambahkan bila perlu. --}}
    </form>

    <noscript>
      <p class="muted" style="margin-top:12px;">
        JavaScript is required to finish login automatically. Please click the button below:
      </p>
      <p style="margin-top:12px;">
        <button onclick="document.getElementById('uam_post_form').submit()" style="padding:8px 14px;border-radius:8px;background:#ef4444;color:#fff;border:0;cursor:pointer;">Continue</button>
      </p>
    </noscript>
  </div>

  <script>
    // Safety: pastikan action (link) bukan kosong
    (function() {
      try {
        // small delay to let the browser set cookies (session) if needed
        setTimeout(function() {
          var f = document.getElementById('uam_post_form');
          if (f && f.action && f.action.indexOf('http') === 0) {
            f.submit();
          } else {
            // jika link invalid, tampilkan info ke user
            document.body.innerHTML = '<div style="padding:20px;text-align:center;"><h3>Unable to continue</h3><p>Please go back and try again.</p></div>';
          }
        }, 250); // 250ms: cukup kecil, memberi waktu browser untuk menyimpan cookie
      } catch(e) {
        // fatal fallback
        console.error(e);
      }
    })();
  </script>
</body>
</html>
