const el = id => document.getElementById(id);
const bounds = [[-11,94],[6,142]];
const dialog = el('details');
const filter = el('prodi');
let map, markers, locations = [], selected = [];
function renderDetails() {
 const query = el('search').value.trim().toLowerCase();
 el('rows').replaceChildren();
 const matches = selected.filter(([program]) => program.toLowerCase().includes(query));
 for (const item of matches) {
  const row = el('rows').insertRow();
  item.forEach(value => row.insertCell().textContent = value);
 }
 el('total').textContent = matches.reduce((sum,[,count]) => sum + count, 0) + ' alumni';
}
el('close').onclick = () => dialog.close();
el('search').oninput = renderDetails;
function draw() {
 markers?.clearLayers();
 el('fallback')?.replaceChildren();
 let total = 0, cities = 0;
 for (const location of locations) {
  const counts = Object.entries(location.counts).filter(([program]) => !filter.value || program === filter.value);
  const count = counts.reduce((sum,[,value]) => sum + value, 0);
  if (!count) continue;
  total += count;
  cities++;
  const label = location.city + ' · ' + location.province;
  const button = document.createElement('button');
  button.className = 'primary';
  button.textContent = map ? count + ' alumni · Lihat detail' : label + ' · ' + count;
  button.onclick = () => {
   selected = counts;
   el('location').textContent = label;
   el('search').value = '';
   renderDetails();
   dialog.showModal();
  };
  if (map) {
   const popup = document.createElement('div');
   const title = document.createElement('p');
   title.textContent = label;
   popup.append(title,button);
   L.marker([location.lat,location.lng],{title:label,alt:label}).bindPopup(popup).addTo(markers);
  } else {
   el('fallback').append(button);
  }
 }
 el('stats').textContent = total + ' alumni · ' + cities + ' kota/kabupaten';
}
filter.onchange = draw;
el('reset').onclick = () => { filter.value = ''; draw(); map?.fitBounds(bounds); };
if (window.L) {
 el('map').replaceChildren();
 map = L.map('map',{scrollWheelZoom:false}).fitBounds(bounds);
 L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:19,attribution:'&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'}).addTo(map);
 markers = L.layerGroup().addTo(map);
} else {
 el('map').innerHTML = '<p class="mapmsg">Peta tidak dapat dimuat. Rincian tersedia dari daftar lokasi.</p><div id="fallback" class="toolbar"></div>';
}
fetch(el('map').dataset.source)
 .then(response => { if (!response.ok) throw new Error('Data unavailable'); return response.json(); })
 .then(data => {
  locations = data.locations;
  data.programs.forEach(program => filter.add(new Option(program,program)));
  draw();
  if (!locations.length) el('stats').textContent = 'Belum ada data alumni.';
 })
 .catch(() => { el('stats').textContent = 'Data alumni tidak dapat dimuat.'; });
