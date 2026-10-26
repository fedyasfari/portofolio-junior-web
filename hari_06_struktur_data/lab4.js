
import { Queue } from './structures.js';

console.log('=== LAB 4: UJI QUEUE ===');

const antrean = new Queue();

// Menguji antrean awal
console.log('Awal:', antrean.toArray());
console.log('Kosong?', antrean.isEmpty());

// Enqueue tiga elemen
antrean.enqueue('A001');
antrean.enqueue('A002');
antrean.enqueue('A003');

console.log('Setelah enqueue:', antrean.toArray());
console.log('Peek:', antrean.peek());
console.log('Jumlah:', antrean.size());

// Dequeue hingga kosong
console.log('Dequeue 1:', antrean.dequeue());
console.log('Dequeue 2:', antrean.dequeue());
console.log('Dequeue 3:', antrean.dequeue());

console.log('Kosong?', antrean.isEmpty());

// Menguji dequeue saat kosong
console.log('Dequeue saat kosong:', antrean.dequeue());

// Menguji Queue dapat digunakan kembali
antrean.enqueue('A004');

console.log('Antrean baru:', antrean.toArray());
console.log('Dequeue 4:', antrean.dequeue());
