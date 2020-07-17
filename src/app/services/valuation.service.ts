import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, of } from 'rxjs';
import { CrudService } from './crud.service';
import { Valuation } from './../models/valuation';
import { environment } from '../../environments/environment';

@Injectable()
export class ValuationService extends CrudService<Valuation> {

	constructor(protected http: HttpClient) {
		super(http, environment.restURL + '/valuation');
	}

	getValuations(): Observable<Valuation[]> {
		return super.list();
	}

	getValuation(id: number): Observable<Valuation> {
		return super.loadByID(id);
	}
}
