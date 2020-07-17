import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

import { Observable, of } from 'rxjs';
import { catchError, tap } from 'rxjs/operators';

import { User } from '../models/user';
import { Status } from '../models/status';

import { environment } from '../../environments/environment';

@Injectable()
export class UserService {
  private urlUser = environment.restURL + '/user';
  private urlUsers = environment.restURL + '/users';

  constructor(private http: HttpClient) {}

  getAllUsers(): Observable<User[]> {
    return this.http
      .get<User[]>(this.urlUsers)
      .pipe(
        catchError(this.handleError('UserService.getAllUsers', null))
      );
  }

  get(): Observable<User> {
    return this.http
      .get<User>(this.urlUser)
      .pipe(catchError(this.handleError('UserService.get', null)));
  }

  save(userData: User): Observable<Status> {
    const id = +userData.id;
    if (id > 0) {
      return this.http
        .put<Status>(this.urlUser, userData)
        .pipe(catchError(this.handleError<Status>('UserService.save')));
    } else {
      return this.http.post<Status>(this.urlUser, userData).pipe(
        tap(data => {
          if (data.status === true) {
            localStorage.setItem('token', data.token);
          }
        }),
        catchError(this.handleError<Status>('UserService.save'))
      );
    }
  }

  delete(): Observable<Status> {
    return this.http
      .delete<Status>(this.urlUser)
      .pipe(catchError(this.handleError<Status>('UserService.delete')));
  }

  private handleError<T>(operation = 'operation', result?: T) {
    return (error: any): Observable<T> => {
      console.error(`${operation} failed: ${error.message}`);
      return of(result as T);
    };
  }
}
