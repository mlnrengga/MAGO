import { test, expect } from '@playwright/test';

test('Verifikasi Tampilan Detail Aktivitas', async ({ page }) => {
  // Akses halaman login
  await page.goto('http://127.0.0.1:8000/login');

  // Isi kolom NIM/NIP dan Password
  await page.fill('input[name="identifier"]', '198804162011031001');  // Ganti dengan NIP yang valid
  await page.fill('input[name="password"]', '12345678');  // Ganti dengan password yang valid

  // Klik tombol login
  await page.click('button[type="submit"]');

  // Tunggu pengalihan halaman setelah login
  await page.waitForNavigation({ waitUntil: 'networkidle' });

  // Arahkan ke halaman Monitoring Aktivitas setelah login
  await page.goto('http://127.0.0.1:8000/pembimbing/monitoringaktivitas-magangs'); // Halaman Monitoring Aktivitas

  // Tunggu elemen tombol "Detail Aktivitas" muncul
  await page.waitForSelector('button:has-text("Detail Aktivitas")');

  // Klik tombol "Detail Aktivitas" pada salah satu baris data
  await page.click('button:has-text("Detail Aktivitas")');

  // Verifikasi bahwa log aktivitas ditampilkan dengan informasi mahasiswa, perusahaan, dan aktivitas
  const mahasiswaInfo = await page.isVisible('text=Mahasiswa');
  const perusahaanInfo = await page.isVisible('text=Perusahaan');
  const aktivitasDetail = await page.isVisible('text=Detail Aktivitas');

  expect(mahasiswaInfo).toBe(true);
  expect(perusahaanInfo).toBe(true);
  expect(aktivitasDetail).toBe(true);
});

test('Menambahkan Feedback dengan input valid', async ({ page }) => {
  // Login otomatis
  await page.goto('http://127.0.0.1:8000/login');
  await page.fill('input[name="identifier"]', '198804162011031001');
  await page.fill('input[name="password"]', '12345678');
  await page.click('button[type="submit"]');
  await page.goto('http://127.0.0.1:8000/pembimbing/monitoringaktivitas-magangs');
  await page.waitForURL('http://127.0.0.1:8000/pembimbing/monitoringaktivitas-magangs');

  // Klik tombol "Beri Feedback"
  await page.click('button:has-text("Beri Feedback")');

  // Isi kolom feedback dengan input valid
  await page.fill('textarea[name="feedback_progres"]', 'Feedback valid dari dosen.');

  // Klik tombol "Simpan Feedback"
  await page.click('button:has-text("Simpan Feedback")');

  // Verifikasi bahwa notifikasi "Created." muncul
  const notification = await page.locator('text=Created.');
  await expect(notification).toBeVisible();

  // Verifikasi bahwa pengguna diarahkan kembali ke halaman Monitoring Aktivitas
  await expect(page).toHaveURL('http://127.0.0.1:8000/pembimbing/monitoringaktivitas-magangs');
});

test('Menambahkan Feedback dengan input kosong', async ({ page }) => {
  // Login otomatis
  await page.goto('http://127.0.0.1:8000/login');
  await page.fill('input[name="identifier"]', '198804162011031001');
  await page.fill('input[name="password"]', '12345678');
  await page.click('button[type="submit"]');
  await page.goto('http://127.0.0.1:8000/pembimbing/monitoringaktivitas-magangs');
  await page.waitForURL('http://127.0.0.1:8000/pembimbing/monitoringaktivitas-magangs');

  // Klik tombol "Beri Feedback"
  await page.click('button:has-text("Beri Feedback")');

  // Kosongkan kolom feedback
  await page.fill('textarea[name="feedback_progres"]', '');

  // Klik tombol "Simpan Feedback"
  await page.click('button:has-text("Simpan Feedback")');

  // Verifikasi bahwa pesan error "Please fill out this field" muncul
  const errorMessage = await page.locator('text=Please fill out this field');
  await expect(errorMessage).toBeVisible();
});
