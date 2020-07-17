
export class Research {
	public date: string;
	public location: string;
	public source: string;
	public value: number;
	public area: number;

	public constructor(json: any = []) {
		if (json.length !== []) {
			this.date = json.date;
			this.location = json.location;
			this.source = json.source;
			this.value = json.value;
			this.area = json.area;
		}
	}
}
export class Composition {
	public living_room: number;
	public kitchen: number;
	public bedroom: number;
	public bathroom: number;
	public service_area: number;
	public balcony: number;
	public barbecue_grill: number;
	public garage: number;
	public deposit: number;
	public parking_lot: number;
	public hall: number;
	public locker_room: number;
	public covered_space: number;
	public others: string;

	public constructor(json: any = []) {
		if (json.length !== []) {
			this.living_room = json.living_room;
			this.kitchen = json.kitchen;
			this.bedroom = json.bedroom;
			this.bathroom = json.bathroom;
			this.service_area = json.service_area;
			this.balcony = json.balcony;
			this.barbecue_grill = json.barbecue_grill;
			this.garage = json.garage;
			this.deposit = json.deposit;
			this.parking_lot = json.parking_lot;
			this.hall = json.hall;
			this.locker_room = json.locker_room;
			this.covered_space = json.covered_space;
			this.others = json.others;
		}
	}
}

export class Valuation {
	public id: number | null;
	public user_id: number;
	public title: string;
	public created_at: string;
	public type: string;
	public client: string;
	public adress: string;
	public value: number;
	public city: string;
	public valuated_at: string;
	public professional: string;
	public profession: string;
	public register: string;
	public land_front: number;
	public land_side: number;
	public land_area: number;
	public house_area: number;
	public house_type: string;
	public standard: string;
	public masonry: string;
	public openings: string;
	public ceiling: string;
	public roof: string;
	public facilities: string;
	public access: string;
	public infrastructure: string;
	public appreciation: string;
	public market: string;
	public research: string;
	public cub: number;
	public bdi: number;
	public fc: number;
	public cd: number;

	public researches: Research[] = [];
	public compositions: Composition = new Composition();

	public constructor(json: any = []) {
		if (json.length !== []) {
			this.id = isNaN(parseInt(json.id, 10)) ? null : parseInt(json.id, 10);
			this.user_id = isNaN(parseInt(json.user_id, 10))
				? null
				: parseInt(json.user_id, 10);
			this.title = json.title;
			this.created_at = json.created_at;
			this.type = json.type;
			this.client = json.client;
			this.adress = json.adress;
			this.value = json.value;
			this.city = json.city;
			this.valuated_at = json.valuated_at;
			this.professional = json.professional;
			this.profession = json.profession;
			this.register = json.register;
			this.land_front = json.land_front;
			this.land_side = json.land_side;
			this.land_area = json.land_area;
			this.house_area = json.house_area;
			this.house_type = json.house_type;
			this.standard = json.standard;
			this.masonry = json.masonry;
			this.openings = json.openings;
			this.ceiling = json.ceiling;
			this.roof = json.roof;
			this.facilities = json.facilities;
			this.access = json.access;
			this.infrastructure = json.infrastructure;
			this.appreciation = json.appreciation;
			this.market = json.market;
			this.research = json.research;
			this.cub = json.cub;
			this.bdi = json.bdi;
			this.fc = json.fc;
			this.cd = json.cd;
		}
	}

}
