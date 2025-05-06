const socket = new WebSocket('ws://localhost:8080');

socket.onopen = () => {
    console.log('WebSocket connection established.');
    // Kirim ID pengguna ke server jika diperlukan
    // socket.send(JSON.stringify({ type: 'auth', userId: getLoggedInUserId() }));
};

socket.onmessage = (event) => {
    const notification = JSON.parse(event.data);
    console.log('Received notification:', notification);
    // Tampilkan notifikasi kepada pengguna (misalnya, menggunakan library notifikasi)
    alert(`New ${notification.type}: ${notification.message}`);
};

socket.onclose = () => {
    console.log('WebSocket connection closed.');
};

socket.onerror = (error) => {
    console.error('WebSocket error:', error);
};
