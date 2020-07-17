import { Status } from './../models/status';
import { HttpClient } from '@angular/common/http';
import { take } from 'rxjs/operators';
import { Injectable } from '@angular/core';

export class CrudService<T> {
	constructor(protected http: HttpClient, protected API_URL) { }

	public list() {
		return this.http
			.get<T[]>(this.API_URL)
			.pipe(take(1));
	}

	public loadByID(id: number) {
		return this.http.get<T>(`${this.API_URL}/${id}`).pipe(take(1));
	}

	public remove(id: number) {
		return this.http.delete<Status>(`${this.API_URL}/${id}`).pipe(take(1));
	}

	public save(record: T) {
		const key = 'id';
		if (record[key]) {
			return this.update(record);
		}
		return this.create(record);
	}

	private create(record: T) {
		return this.http.post<Status>(this.API_URL, record).pipe(take(1));
	}

	private update(record: T) {
		const key = 'id';
		return this.http
			.put<Status>(`${this.API_URL}/${record[key]}`, record)
			.pipe(take(1));
	}
}
