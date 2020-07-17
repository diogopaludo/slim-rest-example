import { Component, OnInit } from '@angular/core';
import { ValuationService } from '../services/valuation.service';
import { ActivatedRoute } from '@angular/router';
import { Valuation } from '../models/valuation';
import { User } from '../models/user';
import { UserService } from '../services/user.service';

@Component({
	selector: 'app-example',
	templateUrl: './example.component.html',
	styleUrls: ['./example.component.css'],
	providers: [
		ValuationService,
		UserService
	]
})
export class ExampleComponent implements OnInit {

	public valuation: Valuation = new Valuation();
	public allValuations: Valuation[];
	public user: User;

	constructor(
		private route: ActivatedRoute,
		private userService: UserService,
		private valuationService: ValuationService
	) { }

	ngOnInit() {
		this.valuation = new Valuation();
		this.userService.get().subscribe(valor => {
			this.user = valor;
		});
		this.route.params.subscribe(params => {
			const id = +params['id'];
			if (id > 0) {
				this.valuationService.getValuation(id).subscribe(value => {
					this.valuation = new Valuation(value);
				});
			} else {
				this.valuationService.getValuations().subscribe(value => {
					value.forEach(v => {
						this.allValuations.push(new Valuation(v));
					});
				});
			}
		});
	}

}
