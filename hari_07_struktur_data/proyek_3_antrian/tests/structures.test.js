import test from 'node:test';
import assert from 'node:assert/strict';
import { LinkedList, LinkedQueue, Stack } from '../js/structures.js';

test('Stack kosong mengembalikan undefined saat pop dan peek', () => {
  const stack = new Stack();
  assert.equal(stack.pop(), undefined);
  assert.equal(stack.peek(), undefined);
  assert.equal(stack.isEmpty(), true);
});

test('Stack LIFO: data terakhir keluar lebih dahulu', () => {
  const stack = new Stack();
  stack.push('A'); stack.push('B'); stack.push('C');
  assert.equal(stack.peek(), 'C');
  assert.deepEqual([stack.pop(), stack.pop(), stack.pop()], ['C', 'B', 'A']);
  assert.equal(stack.size, 0);
});

test('Stack dengan batas 2 menghapus nilai paling lama', () => {
  const stack = new Stack(2);
  stack.push('awal'); stack.push('kedua'); stack.push('ketiga');
  assert.equal(stack.size, 2);
  assert.equal(stack.pop(), 'ketiga');
  assert.equal(stack.pop(), 'kedua');
});

test('Stack menolak batas kapasitas tidak valid', () => {
  assert.throws(() => new Stack(0), RangeError);
  assert.throws(() => new Stack(-2), RangeError);
});

test('Stack clear mengosongkan semua nilai', () => {
  const stack = new Stack();
  stack.push(1); stack.push(2); stack.clear();
  assert.equal(stack.isEmpty(), true);
});

test('LinkedList: addFirst, addLast dan toArray', () => {
  const list = new LinkedList();
  list.addFirst('B'); list.addFirst('A'); list.addLast('C');
  assert.deepEqual(list.toArray(), ['A', 'B', 'C']);
  assert.equal(list.size, 3);
});

test('LinkedList: removeFirst menangani kosong dan satu elemen', () => {
  const list = new LinkedList();
  assert.equal(list.removeFirst(), undefined);
  list.addLast('A');
  assert.equal(list.removeFirst(), 'A');
  assert.equal(list.isEmpty(), true);
  list.addLast('B');
  assert.deepEqual(list.toArray(), ['B']);
});

test('LinkedList: find/peekFirst dan nilai tidak ditemukan', () => {
  const list = new LinkedList();
  list.addLast('X'); list.addLast('Y');
  assert.equal(list.find('Y'), 'Y');
  assert.equal(list.find('T'), undefined);
  assert.equal(list.peekFirst(), 'X');
});

test('LinkedList: clear mengosongkan seluruh node', () => {
  const list = new LinkedList();
  list.addLast(1); list.addLast(2); list.clear();
  assert.equal(list.size, 0);
  assert.deepEqual(list.toArray(), []);
});

test('LinkedQueue menjaga urutan FIFO', () => {
  const antrean = new LinkedQueue();
  antrean.enqueue('A001'); antrean.enqueue('A002'); antrean.enqueue('A003');
  assert.equal(antrean.peek(), 'A001');
  assert.equal(antrean.dequeue(), 'A001');
  assert.equal(antrean.dequeue(), 'A002');
  assert.deepEqual(antrean.toArray(), ['A003']);
});

test('LinkedQueue: dequeue ketika kosong tidak melempar error', () => {
  const antrean = new LinkedQueue();
  assert.equal(antrean.dequeue(), undefined);
  assert.equal(antrean.size, 0);
  assert.equal(antrean.peek(), undefined);
});

test('LinkedQueue: clear dan pemakaian kembali', () => {
  const antrean = new LinkedQueue();
  antrean.enqueue('A001'); antrean.clear(); antrean.enqueue('A999');
  assert.equal(antrean.dequeue(), 'A999');
  assert.equal(antrean.isEmpty(), true);
});
