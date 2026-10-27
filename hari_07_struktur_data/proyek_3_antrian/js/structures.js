/**
 * Struktur data murni tanpa DOM dan browser.
 * Stack: LIFO; LinkedQueue: FIFO; LinkedList: penyimpanan node terhubung.
 */

/** Stack berbasis array, dengan pilihan batas kapasitas. */
export class Stack {
  #data = [];
  #maksimum;

  constructor(maksimum = Infinity) {
    if (maksimum !== Infinity && (!Number.isInteger(maksimum) || maksimum < 1)) {
      throw new RangeError('Batas Stack harus bilangan bulat positif.');
    }
    this.#maksimum = maksimum;
  }

  push(nilai) {
    if (this.#data.length >= this.#maksimum) this.#data.shift();
    this.#data.push(nilai);
  }

  pop() {
    return this.#data.pop();
  }

  peek() {
    return this.#data.at(-1);
  }

  clear() {
    this.#data.length = 0;
  }

  isEmpty() {
    return this.#data.length === 0;
  }

  get size() {
    return this.#data.length;
  }
}

/** Node hanya digunakan di dalam implementasi LinkedList. */
class Node {
  constructor(data) {
    this.data = data;
    this.next = null;
  }
}

/** Singly Linked List dengan pointer head dan tail. */
export class LinkedList {
  #head = null;
  #tail = null;
  #panjang = 0;

  addFirst(data) {
    const node = new Node(data);
    node.next = this.#head;
    this.#head = node;
    if (this.#tail === null) this.#tail = node;
    this.#panjang++;
  }

  addLast(data) {
    const node = new Node(data);
    if (this.#tail === null) this.#head = node;
    else this.#tail.next = node;
    this.#tail = node;
    this.#panjang++;
  }

  removeFirst() {
    if (this.#head === null) return undefined;
    const data = this.#head.data;
    this.#head = this.#head.next;
    if (this.#head === null) this.#tail = null;
    this.#panjang--;
    return data;
  }

  peekFirst() {
    return this.#head?.data;
  }

  find(data) {
    let node = this.#head;
    while (node !== null) {
      if (Object.is(node.data, data)) return node.data;
      node = node.next;
    }
    return undefined;
  }

  toArray() {
    const hasil = [];
    let node = this.#head;
    while (node !== null) {
      hasil.push(node.data);
      node = node.next;
    }
    return hasil;
  }

  clear() {
    this.#head = null;
    this.#tail = null;
    this.#panjang = 0;
  }

  isEmpty() {
    return this.#panjang === 0;
  }

  get size() {
    return this.#panjang;
  }
}

/** FIFO: enqueue/addLast dan dequeue/removeFirst keduanya O(1). */
export class LinkedQueue {
  #list = new LinkedList();

  enqueue(data) {
    this.#list.addLast(data);
  }

  dequeue() {
    return this.#list.removeFirst();
  }

  peek() {
    return this.#list.peekFirst();
  }

  toArray() {
    return this.#list.toArray();
  }

  clear() {
    this.#list.clear();
  }

  isEmpty() {
    return this.#list.isEmpty();
  }

  get size() {
    return this.#list.size;
  }
}
