<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>GSG Alarm</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="assets/css/inter.css" rel="stylesheet">
    <link href="assets/css/orbitron.css" rel="stylesheet">
    <link href="assets/icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>
    <div class="container mt-3">
        <div class="alert-placeholder"></div>
    </div>

    <div class="text-center py-5 clock-section">
        <div id="lcd-clock" class="lcd-display mb-2">00:00:00</div>
        <div id="lcd-date" class="text-primary small-opacity">Senin, 1 Jan 2025</div>
        <div id="next-alarm-info" class="text-muted mb-2">
            <small><span id="next-alarm-name">-</span> | <span id="next-alarm-time">-</span></small>
        </div>
        <div id="countdown" class="countdown">Waktu tersisa: --:--:--</div>
        <button id="minimize-btn" onclick="minimizeToTray()" class="btn btn-sm btn-outline-primary mt-3" style="display:none;">
            ⏴ Minimize ke Tray
        </button>
    </div>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-dark mb-0">⏰ Daftar Alarm</h2>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addAlarmModal">
                <i class="bi bi-plus-circle"></i> Tambah Alarm
            </button>
        </div>

        <div class="card">
            <div class="card-header">Alarm yang Diset</div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Waktu</th>
                            <th>Hari</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="alarm-list">
                        <tr>
                            <td colspan="5" class="text-center text-muted">Memuat...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addAlarmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="addAlarmForm" onsubmit="submitForm(); return false;">
                    <input type="hidden" name="action" value="add">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="bi bi-alarm"></i> Tambah Alarm Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label><i class="bi bi-megaphone"></i> Nama Alarm</label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Bangun Pagi" required>
                        </div>
                        <div class="mb-3">
                            <label><i class="bi bi-clock"></i> Waktu</label>
                            <input type="time" name="time" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label><i class="bi bi-calendar3"></i> Pilih Hari Aktif</label>
                            <div class="d-flex flex-wrap gap-3 mt-2">
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="days[]" value="Monday" id="d_Monday"><label class="form-check-label" for="d_Monday">Senin</label></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="days[]" value="Tuesday" id="d_Tuesday"><label class="form-check-label" for="d_Tuesday">Selasa</label></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="days[]" value="Wednesday" id="d_Wednesday"><label class="form-check-label" for="d_Wednesday">Rabu</label></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="days[]" value="Thursday" id="d_Thursday"><label class="form-check-label" for="d_Thursday">Kamis</label></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="days[]" value="Friday" id="d_Friday"><label class="form-check-label" for="d_Friday">Jumat</label></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="days[]" value="Saturday" id="d_Saturday"><label class="form-check-label" for="d_Saturday">Sabtu</label></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="days[]" value="Sunday" id="d_Sunday"><label class="form-check-label" for="d_Sunday">Minggu</label></div>
                            </div>
                            <small class="text-muted">Centang hari-hari di mana alarm ingin berbunyi.</small>
                        </div>
                        <div class="mb-3">
                            <label><i class="bi bi-music-note-beamed"></i> Upload Suara (opsional)</label>
                            <input type="file" name="audio" class="form-control" accept=".mp3,.wav,.ogg">
                            <small class="text-muted">Biarkan kosong untuk suara default</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Simpan Alarm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="minimized-panel" style="
        position: fixed; bottom: 20px; right: 20px; width: 300px; height: 60px;
        background: linear-gradient(135deg, #0050b3, #003a80); color: white; border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.3); display: none; flex-direction: column;
        justify-content: center; padding: 10px 15px; font-family: 'Inter', sans-serif;
        cursor: pointer; z-index: 9999; border: 1px solid #0088cc; transition: all 0.3s ease;
    " onclick="restoreWindow()">
        <div style="font-weight: 600; font-size: 0.9rem;">GSG Alarm</div>
        <div style="font-size: 0.85rem; opacity: 0.9;"><span id="panel-clock">00:00</span> | <span id="panel-date">01 Jan</span></div>
    </div>

    <div class="toast-container">
        <div id="toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
            <div class="toast-header"><strong class="me-auto">Alarm</strong><button type="button" class="btn-close" data-bs-dismiss="toast"></button></div>
            <div class="toast-body" id="toast-body"></div>
        </div>
    </div>

    <audio id="alarmSound" preload="auto"></audio>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script>
        let alarms = [];
        const dayMap = {
            0: "Sunday",
            1: "Monday",
            2: "Tuesday",
            3: "Wednesday",
            4: "Thursday",
            5: "Friday",
            6: "Saturday"
        };

        function pad2(n) {
            return n < 10 ? '0' + n : '' + n;
        }

        async function loadAlarms() {
            try {
                const res = await fetch('api/get.php');
                alarms = await res.json();
                renderAlarms();
            } catch (e) {
                document.getElementById('alarm-list').innerHTML = '<tr><td colspan="5" class="text-danger">Gagal muat alarm</td></tr>';
            }
        }

        function renderAlarms() {
            const tbody = document.getElementById('alarm-list');
            if (alarms.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted">Belum ada alarm</td></tr>';
                return;
            }

            const labels = {
                Monday: 'Senin',
                Tuesday: 'Selasa',
                Wednesday: 'Rabu',
                Thursday: 'Kamis',
                Friday: 'Jumat',
                Saturday: 'Sabtu',
                Sunday: 'Minggu'
            };
            tbody.innerHTML = alarms.map((a, i) => {
                const days = a.days.map(d => labels[d] || d).join(', ');
                return `
                <tr>
                    <td>${i+1}</td>
                    <td>${htmlspecialchars(a.name)}</td>
                    <td><strong>${a.time}</strong></td>
                    <td>${htmlspecialchars(days)}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-danger me-1" onclick="confirmDelete('${a.id}')">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                        <button class="btn btn-sm btn-outline-primary" onclick="playAlarm('${a.audio}')">
                            <i class="bi bi-play-circle"></i> Mainkan
                        </button>
                    </td>
                </tr>`;
            }).join('');
        }

        async function submitForm() {
            const form = document.getElementById('addAlarmForm');
            const formData = new FormData(form);
            try {
                const res = await fetch('api/add.php', {
                    method: 'POST',
                    body: formData
                });
                const data = await res.json();
                if (data.success) {
                    showToast('Alarm ditambahkan!', 'success');
                    form.reset();
                    bootstrap.Modal.getInstance(document.getElementById('addAlarmModal')).hide();
                    loadAlarms();
                } else {
                    showToast('Error: ' + data.error, 'danger');
                }
            } catch (e) {
                showToast('Gagal kirim data.', 'danger');
            }
        }

        async function confirmDelete(id) {
            if (confirm('Hapus alarm ini?')) {
                try {
                    const res = await fetch(`api/delete.php?id=${id}`);
                    const data = await res.json();
                    if (data.success) {
                        showToast('Dihapus!', 'success');
                        loadAlarms();
                    } else {
                        showToast('Gagal hapus.', 'danger');
                    }
                } catch (e) {
                    showToast('Error.', 'danger');
                }
            }
        }

        function playAlarm(file) {
            const sound = document.getElementById('alarmSound');
            sound.src = 'sounds/' + (file || 'alarm.mp3');
            sound.play().catch(() => {});
        }

        function showToast(msg, type) {
            const toastEl = document.getElementById('toast');
            const toastBody = document.getElementById('toast-body');
            toastBody.textContent = msg;
            new bootstrap.Toast(toastEl).show();
        }

        function updateClock() {
            const now = new Date();
            document.getElementById('lcd-clock').textContent = pad2(now.getHours()) + ':' + pad2(now.getMinutes()) + ':' + pad2(now.getSeconds());
            const wd = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const day = now.getDate();
            const month = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'][now.getMonth()];
            document.getElementById('lcd-date').textContent = wd[now.getDay()] + ', ' + day + ' ' + month + ' ' + now.getFullYear();
            updatePanelClock();
            checkAlarms(now);
            updateCountdown(now);
        }

        function updatePanelClock() {
            const now = new Date();
            document.getElementById('panel-clock').textContent = pad2(now.getHours()) + ':' + pad2(now.getMinutes());
            document.getElementById('panel-date').textContent = now.getDate() + ' ' + ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'][now.getMonth()];
        }

        function updateCountdown(now) {
            let next = null,
                diff = null;
            for (const a of alarms) {
                if (!a.time || !a.days) continue;
                const [h, m] = a.time.split(':');
                for (let d = 0; d < 7; d++) {
                    const f = new Date(now);
                    f.setDate(now.getDate() + d);
                    f.setHours(+h, +m, 0, 0);
                    const dayName = dayMap[f.getDay()];
                    if (a.days.includes(dayName)) {
                        let d = (f - now) / 1000;
                        if (d < 0) d += 86400;
                        if (diff === null || d < diff) {
                            diff = d;
                            next = a;
                        }
                    }
                }
            }
            if (next && diff !== null) {
                const h = Math.floor(diff / 3600),
                    m = Math.floor((diff % 3600) / 60),
                    s = Math.floor(diff % 60);
                document.getElementById('countdown').textContent = 'Waktu tersisa: ' + pad2(h) + ':' + pad2(m) + ':' + pad2(s);
                document.getElementById('next-alarm-name').textContent = next.name;
                document.getElementById('next-alarm-time').textContent = next.time;
            } else {
                document.getElementById('countdown').textContent = 'Tidak ada alarm mendatang';
            }
        }

        let alarmChecked = {};

        function checkAlarms(now) {
            const time = pad2(now.getHours()) + ':' + pad2(now.getMinutes());
            const day = dayMap[now.getDay()];
            for (const a of alarms) {
                if (a.time === time && a.days.includes(day)) {
                    const last = alarmChecked[a.id];
                    const nowMs = now.getTime();
                    if (!last || (nowMs - last) >= 60000) {
                        alarmChecked[a.id] = nowMs;
                        triggerAlarm(a.name, a.audio);
                    }
                }
            }
        }

        function triggerAlarm(name, file) {
            const sound = document.getElementById('alarmSound');
            sound.src = 'sounds/' + (file || 'alarm.mp3');
            sound.play().catch(() => {});
            document.getElementById('lcd-clock').classList.add('alarm-active');
            if (typeof GrahaSaranaAlarm !== "undefined") {
                GrahaSaranaAlarm.notifications.create({
                    title: "⏰ ALARM!",
                    body: name + " - Waktu tiba!",
                    onclick: () => {
                        GrahaSaranaAlarm.window.restore();
                        stopAlarm();
                    },
                    onclose: stopAlarm
                });
            }
            sound.onended = stopAlarm;
        }

        function stopAlarm() {
            const sound = document.getElementById('alarmSound');
            sound.pause();
            sound.currentTime = 0;
            document.getElementById('lcd-clock').classList.remove('alarm-active');
        }

        function minimizeToTray() {
            document.querySelectorAll('.container, .clock-section').forEach(el => el.style.display = 'none');
            document.getElementById('minimized-panel').style.display = 'flex';
            if (typeof GrahaSaranaAlarm !== "undefined") GrahaSaranaAlarm.window.minimize();
        }

        function restoreWindow() {
            document.querySelectorAll('.container, .clock-section').forEach(el => el.style.display = 'block');
            document.getElementById('minimized-panel').style.display = 'none';
            if (typeof GrahaSaranaAlarm !== "undefined") GrahaSaranaAlarm.window.restore();
        }

        function htmlspecialchars(str) {
            const div = document.createElement('div');
            div.textContent = str;
            return div.innerHTML;
        }

        document.addEventListener("DOMContentLoaded", () => {
            loadAlarms();
            setInterval(updateClock, 1000);
            if (typeof GrahaSaranaAlarm !== "undefined") {
                document.getElementById("minimize-btn").style.display = "block";
            }
        });
    </script>
</body>

</html>