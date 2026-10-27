// ==========================================
// LAB 1 - STRUKTUR DATA HARI 7
// LinkedList, LinkedQueue, Stack, dan Queue
// ==========================================

// Satu node menyimpan data dan alamat node berikutnya.
class Node {
  constructor(data) {
    this.data = data;
    this.next = null;
  }
}

// 1. LINKED LIST (satu arah / singly linked list)
export class LinkedList {
  constructor() {
    this.head = null;
    this.tail = null;
    this._size = 0;
  }

  addFirst(data) {
    const nodeBaru = new Node(data);
    nodeBaru.next = this.head;
    this.head = nodeBaru;

    if (this.tail === null) {
      this.tail = nodeBaru;
    }
    this._size++;
  }

  addLast(data) {
    const nodeBaru = new Node(data);

    if (this.head === null) {
      this.head = nodeBaru;
      this.tail = nodeBaru;
    } else {
      this.tail.next = nodeBaru;
      this.tail = nodeBaru;
    }
    this._size++;
  }

  removeFirst() {
    if (this.head === null) return undefined;

    const dataTerhapus = this.head.data;
    this.head = this.head.next;

    if (this.head === null) {
      this.tail = null;
    }
    this._size--;
    return dataTerhapus;
  }

  find(data) {
    let sekarang = this.head;
    while (sekarang !== null) {
      if (sekarang.data === data) return sekarang;
      sekarang = sekarang.next;
    }
    return null;
  }

  toArray() {
    const hasil = [];
    let sekarang = this.head;
    while (sekarang !== null) {
      hasil.push(sekarang.data);
      sekarang = sekarang.next;
    }
    return hasil;
  }

  // Menghapus NODE PERTAMA yang memiliki nilai data.
  // Mengembalikan true jika ditemukan, false jika tidak.
  remove(data) {
    // Kasus 1: linked list masih kosong.
    if (this.head === null) return false;

    // Kasus 2: node yang dicari adalah kepala (head).
    if (this.head.data === data) {
      this.removeFirst();
      return true;
    }

    // Kasus 3: cari node pada bagian tengah/ekor.
    let sebelumnya = this.head;
    let sekarang = this.head.next;

    while (sekarang !== null) {
      if (sekarang.data === data) {
        // Lewati node sekarang: hubungkan node sebelumnya ke node sesudahnya.
        sebelumnya.next = sekarang.next;

        // Jika node yang dihapus adalah ekor, geser penunjuk tail.
        if (sekarang === this.tail) {
          this.tail = sebelumnya;
        }

        this._size--;
        return true;
      }

      sebelumnya = sekarang;
      sekarang = sekarang.next;
    }

    // Kasus 4: data tidak ditemukan; list tidak berubah.
    return false;
  }

  isEmpty() {
    return this._size === 0;
  }

  size() {
    return this._size;
  }
}

// 2. LINKED QUEUE - antrean menggunakan node terhubung.
export class LinkedQueue {
  constructor() {
    this.head = null;
    this.tail = null;
    this._size = 0;
  }

  enqueue(data) {
    const nodeBaru = new Node(data);
    if (this.tail === null) {
      this.head = nodeBaru;
      this.tail = nodeBaru;
    } else {
      this.tail.next = nodeBaru;
      this.tail = nodeBaru;
    }
    this._size++;
  }

  dequeue() {
    if (this.head === null) return undefined;

    const dataKeluar = this.head.data;
    this.head = this.head.next;

    if (this.head === null) this.tail = null;
    this._size--;
    return dataKeluar;
  }

  peek() {
    return this.head === null ? undefined : this.head.data;
  }

  isEmpty() {
    return this._size === 0;
  }

  size() {
    return this._size;
  }

  toArray() {
    const hasil = [];
    let sekarang = this.head;
    while (sekarang !== null) {
      hasil.push(sekarang.data);
      sekarang = sekarang.next;
    }
    return hasil;
  }
}

// 3. STACK - sesuai pendekatan array di Hari 6 (LIFO).
export class Stack {
  constructor(batas = Infinity) {
    this.items = [];
    this.batas = batas;
  }

  push(data) {
    if (this.size() >= this.batas) throw new Error('Stack penuh.');
    this.items.push(data);
  }

  pop() {
    return this.items.pop();
  }

  peek() {
    return this.items[this.items.length - 1];
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

// 4. QUEUE HARI 6 - array dengan indeks head/tail,
// BUKAN queue shift() yang akan dibandingkan pada benchmark.
export class Queue {
  constructor() {
    this.items = [];
    this.head = 0;
    this.tail = 0;
  }

  enqueue(data) {
    this.items[this.tail] = data;
    this.tail++;
  }

  dequeue() {
    if (this.isEmpty()) return undefined;

    const dataKeluar = this.items[this.head];
    delete this.items[this.head];
    this.head++;

    if (this.isEmpty()) this.clear();
    return dataKeluar;
  }

  peek() {
    return this.isEmpty() ? undefined : this.items[this.head];
  }

  isEmpty() {
    return this.head === this.tail;
  }

  size() {
    return this.tail - this.head;
  }

  toArray() {
    return this.items.slice(this.head, this.tail);
  }

  clear() {
    this.items = [];
    this.head = 0;
    this.tail = 0;
  }
}
