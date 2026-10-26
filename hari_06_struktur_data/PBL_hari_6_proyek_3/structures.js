/**
 * PBL Hari 6 - Dua struktur data yang dipakai aplikasi.
 * Stack: LIFO (Last In, First Out).
 * Queue: FIFO (First In, First Out), versi head/tail.
 */

export class Stack {
  constructor(batas = Infinity) {
    if (!(batas === Infinity || (Number.isInteger(batas) && batas >= 0))) {
      throw new RangeError('Batas Stack harus bilangan bulat nonnegatif.');
    }
    this.items = [];
    this.batas = batas;
  }

  push(nilai) {
    if (this.batas === 0) return;
    this.items.push(nilai);
    // Buang snapshot paling lama jika melebihi batas riwayat.
    if (this.items.length > this.batas) this.items.shift();
  }

  pop() {
    return this.isEmpty() ? undefined : this.items.pop();
  }

  peek() {
    return this.isEmpty() ? undefined : this.items[this.items.length - 1];
  }

  isEmpty() {
    return this.items.length === 0;
  }

  size() {
    return this.items.length;
  }

  clear() {
    this.items = [];
  }
}

export class Queue {
  constructor() {
    this.items = {};
    this.head = 0;
    this.tail = 0;
  }

  enqueue(nilai) {
    this.items[this.tail] = nilai;
    this.tail++;
  }

  dequeue() {
    if (this.isEmpty()) return undefined;

    const nilai = this.items[this.head];
    delete this.items[this.head];
    this.head++;

    // Supaya indeks tidak terus membesar sesudah antrean habis.
    if (this.isEmpty()) this.clear();
    return nilai;
  }

  peek() {
    return this.isEmpty() ? undefined : this.items[this.head];
  }

  isEmpty() {
    return this.size() === 0;
  }

  size() {
    return this.tail - this.head;
  }

  toArray() {
    const hasil = [];
    for (let i = this.head; i < this.tail; i++) {
      hasil.push(this.items[i]);
    }
    return hasil;
  }

  clear() {
    this.items = {};
    this.head = 0;
    this.tail = 0;
  }
}
