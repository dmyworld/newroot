const express = require('express');
const http = require('http');
const { Server } = require('socket.io');
const cors = require('cors');

const app = express();
app.use(cors());
app.use(express.json());

const server = http.createServer(app);
const io = new Server(server, {
    cors: {
        origin: "*", // allow any origin for now
        methods: ["GET", "POST"]
    }
});

io.on('connection', (socket) => {
    console.log(`User connected: ${socket.id}`);

    // Join specific location/business room
    socket.on('join_room', (data) => {
        const room = `biz_${data.business_id}_loc_${data.location_id}`;
        socket.join(room);
        console.log(`Socket ${socket.id} joined room ${room}`);
    });

    socket.on('disconnect', () => {
        console.log(`User disconnected: ${socket.id}`);
    });
});

// Endpoint for CodeIgniter to Trigger Real-Time Events
app.post('/trigger-event', (req, res) => {
    const { event, data, business_id, location_id } = req.body;
    
    if (!event || !data) {
        return res.status(400).json({ status: 'Error', message: 'Missing event or data' });
    }

    // Broadcast conditionally based on room or globally
    if (business_id && location_id) {
        const room = `biz_${business_id}_loc_${location_id}`;
        io.to(room).emit(event, data);
        console.log(`Emitted ${event} to room: ${room}`);
    } else {
        io.emit(event, data); // Global broadcast (e.g. system alerts)
        console.log(`Emitted global event: ${event}`);
    }

    res.json({ status: 'Success', message: 'Event broadcasted' });
});

const PORT = process.env.PORT || 3000;
server.listen(PORT, () => {
    console.log(`Socket.io server running on port ${PORT}`);
});
