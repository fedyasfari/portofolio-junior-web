
export class Stack {
  constructor() {
    this.items = [];
  }

  // Memasukkan data
  push(elemen) {
    this.items.push(elemen);
  }

  // Mengambil data paling atas
  pop() {
    if (this.isEmpty()) {
      return undefined;
    }

    return this.items.pop();
  }

  // Melihat data paling atas
  peek() {
    if (this.isEmpty()) {
      return undefined;
    }

    return this.items[this.items.length - 1];
  }

  // Mengecek apakah kosong
  isEmpty() {
    return this.items.length === 0;
  }

  // Menghitung jumlah elemen
  size() {
    return this.items.length;
  }
}





// LAB 4 - QUEUE (FIFO)
export class Queue {
  constructor() {
    this.items = {};
    this.head = 0;
    this.tail = 0;
  }

  // Menambahkan elemen ke belakang antrean
  enqueue(elemen) {
    this.items[this.tail] = elemen;
    this.tail++;
  }

  // Mengambil elemen terdepan
  dequeue() {
    if (this.isEmpty()) {
      return undefined;
    }

    const elemen = this.items[this.head];

    delete this.items[this.head];
    this.head++;

    // Mengatur ulang indeks jika antrean kosong
    if (this.isEmpty()) {
      this.head = 0;
      this.tail = 0;
    }

    return elemen;
  }

  // Melihat elemen paling depan
  peek() {
    if (this.isEmpty()) {
      return undefined;
    }

    return this.items[this.head];
  }

  // Menghitung jumlah antrean
  size() {
    return this.tail - this.head;
  }

  // Memeriksa apakah antrean kosong
  isEmpty() {
    return this.size() === 0;
  }

  // Mengubah isi antrean menjadi Array
  toArray() {
    const hasil = [];

    for (let i = this.head; i < this.tail; i++) {
      hasil.push(this.items[i]);
    }

    return hasil;
  }
}
