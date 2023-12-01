function updateTime() {
  const now = new Date();
  const hours = (now.getHours() % 12 || 12).toString().padStart(2, '0');
  const minutes = now.getMinutes().toString().padStart(2, '0');
  const seconds = now.getSeconds().toString().padStart(2, '0');
  const ampm = now.getHours() >= 12 ? 'PM' : 'AM';
  const timeString = `${hours}:${minutes}:${seconds} ${ampm}`;
  
  const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
  const month = months[now.getMonth()];
  const day = now.getDate();
  const year = now.getFullYear();
  const dateString = `${month} ${day}, ${year}`;
  
  document.getElementById('time').innerText = timeString;
  document.getElementById('date').innerText = dateString;
}

// Update time every second
setInterval(updateTime, 1000);

// Initial update
updateTime();
