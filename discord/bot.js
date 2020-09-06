const Discord = require('discord.js');
const fetch = require('node-fetch');
const querystring = require('querystring');
const fs = require('fs' );
const client = new Discord.Client();
const {
	prefix,
	token,
	api-url
} = require('./config.json');


client.once('ready', () => {
	client.user.setActivity("heckfire | !help", {
		type: "playing"
	})
	console.log(`AllyBot has started, with ${client.users.size} users, in ${client.channels.size} channels of ${client.guilds.size} servers.`); 
});

client.on('message', async message => {
	if (!message.content.startsWith(prefix) || message.author.bot) return;
	if (message.channel.type == "dm") return;
	const args = message.content.slice(prefix.length).split(/ +/);
	const command = args.shift().toLowerCase();


	///Start Allies Command
	if (command === 'allies') {
		if (!args.length) {
			return message.channel.send('You need to supply a search term!');
		}

		const query = querystring.stringify({
			s: args.join(' ')
		});

		const {
			records
		} = await fetch(`{api-url}/allies/search.php?${query}&server=${message.guild.id}`).then(response => response.json());
		console.log('Ally Search Request:');
		console.log(query);
		console.log(message.guild.id);
		if (!records) {
			return message.channel.send(`No results found.`);
		}
		const [answer] = records;
		var allyresult = `  Allies: ${answer.owner}\n`;
		allyresult += "```";
		allyresult += `+-----------+-------+-------+\n| Ally Name | Value | Owner |\n+-----------+-------+-------+\n`;
		for (i of records) {
			allyresult += (`| ${i.allyname} | ${i.value} | ${i.owner} [${i.clan}]  |\n`);
		}
		allyresult += "+-----------+-------+-------+\n";
		allyresult += "```";
		message.channel.send(allyresult);
	}

	///End Allies Command

	///Start Value Command
		if (command === 'value') {
			if (!args.length) {
				return message.channel.send('You need to supply a search term!');
			}
	
			const query = querystring.stringify({
				s: args.join(' ')
			});
	
			const {
				records
			} = await fetch(`{api-url}/allies/value.php?${query}&server=${message.guild.id}`).then(response => response.json());
			console.log('Ally Value Request:');
			console.log(query);
			console.log(message.guild.id);
			if (!records) {
				return message.channel.send(`No results found.`);
			}
			const [answer] = records;
			var allyresult = `Allies for price: ${answer.value}\n`;
			allyresult += "```";
			allyresult += `+-----------+-------+-------+\n| Ally Name | Value | Owner |\n+-----------+-------+-------+\n`;
			for (i of records) {
				allyresult += (`| ${i.allyname} | ${i.value} | ${i.owner} [${i.clan}] \n`);
			}
			allyresult += "+-----------+-------+-------+\n";
			allyresult += "```";
			message.channel.send(allyresult);
		}
	
	///End Value Command

	///Start List Command
	if (command === 'list') {
		if (!args.length) {
			return message.channel.send('You need to supply a search term!');
		}

		const query = querystring.stringify({
			s: args.join(' ')
		});

		const {
			records
		} = await fetch(`{api-url}/allies/search.php?${query}&server=${message.guild.id}`).then(response => response.json());
		console.log('List Request:');
		console.log(query);
		console.log(message.guild.id);
		if (!records) {
			return message.channel.send(`No results found.`);
		}

		const [answer] = records;
		var listresult = `Allies for: ${answer.owner}\n`;
		listresult += "```";
		for (i of records) {
			listresult += (`${i.allyname},${i.value}\n`);
		}
		listresult += "```";
		message.channel.send(listresult);
	}
	///End List Command

	///Start Clan Command
	if (command === 'clan') {
		if (!args.length) {
			return message.channel.send('use !clan clan');
		}

		const query = querystring.stringify({
			s: args.join(' ')
		});
		const {
			records
		} = await fetch(`{api-url}/allies/owners.php?${query}&server=${message.guild.id}`).then(response => response.json());
		console.log('Clan Request:');
		console.log(query);
		console.log(message.guild.id);
		if (!records) {
			return message.channel.send(`No results found.`);
		}


		const [answer] = records;

		var clanresult = `List of all owners: ${answer.clan}\n`;
		clanresult += "```";
		clanresult += `+-------------+\n|	Owner	|\n+-------------+\n`;
		for (i of records) {
			clanresult += (`| ${i.owner}\n`);
		}
		clanresult += "+-----------+\n";
		clanresult += "```";
		message.channel.send(clanresult);
	}
	///End Clan Command 

	///Start Clanlist Command
	if (command === 'clanlist') {
		const {
			records
		} = await fetch(`{api-url}/allies/clanlist.php?server=${message.guild.id}`).then(response => response.json());
		console.log('Clanlist Request');
		console.log(message.guild.id);
		if (!records) {
			return message.channel.send(`No results found.`);
		}


		const [answer] = records;
		var clanresult = `Clans:\n`;
		clanresult += "```";
		for (i of records) {
			clanresult += (`${i.clan}\n`);
		}
		clanresult += "```";
		message.channel.send(clanresult);
	}
	///End Clanlist Command 

	///Start Delete Command
	if (command === 'delete') {
		if (!args.length) {
			return message.channel.send('You need add the ally name!');
			console.log('update ally request');
		}
		fetch(`{api-url}/allies/delete.php`, {
			method: 'POST',
			body: JSON.stringify({
				allyname: args[0],
				server: message.guild.id
			})
		}).then(function (response) {
			message.channel.send(`deleted`);
			console.log('delete ally request');
			console.log(JSON.stringify({
				allyname: args[0],
				server: message.guild.id
			}));
		})
	}
	///End Delete Command

	///Start Update Command
	if (command === 'update') {
		if (!args.length) {
			return message.channel.send('You need add the ally name, value, owner and clan!');
			console.log('update ally request');
		}
		fetch(`{api-url}/allies/update.php`, {
			method: 'POST',
			body: JSON.stringify({
				allyname: args[0],
				value: args[1],
				owner: args[2],
				clan: args[3],
				server: message.guild.id
			})
		}).then(function (response) {
			message.channel.send(`updated`);
			console.log('updated ally request');
			console.log(JSON.stringify({
				allyname: args[0],
				value: args[1],
				owner: args[2],
				clan: args[3],
				server: message.guild.id
			}));
		})
	}
	///End Update Command

	///Start Add Command
	if (command === 'add') {
		if (!args.length) {
			return message.channel.send('You need add the ally name, value, owner and clan!');
		}
		fetch(`{api-url}/allies/add.php`, {
			method: 'POST',
			body: JSON.stringify({
				allyname: args[0],
				value: args[1],
				owner: args[2],
				clan: args[3],
				server: message.guild.id
			})
		}).then(function (response) {
			message.channel.send(`added`);
			console.log('add ally request');
			console.log(JSON.stringify({
				allyname: args[0],
				value: args[1],
				owner: args[2],
				clan: args[3],
				server: message.guild.id
			}));
		})
	}
	///End Add Command

	///Start Pins Command
	if (command === 'pins') {
		if (!args.length) {
			return message.channel.send('You need to supply a search term!');
		}

		const query = querystring.stringify({
			s: args.join(' ')
		});

		const {
			records
		} = await fetch(`{api-url}/pins/search.php?${query}&server=${message.guild.id}`).then(response => response.json());
		console.log('Pin Search Request:');
		console.log(query);
		console.log(message.guild.id);
		if (!records) {
			return message.channel.send(`No results found.`);
		}
		const [answer] = records;
		var allyresult = `  Pins: ${answer.realm}\n`;
		allyresult += "```";
		allyresult += `+-----+-----+-----+-----+\n| Clan | X | Y | Realm |\n+-----+-----+-----+-----+\n`;
		for (i of records) {
			allyresult += (`| ${i.clan} | ${i.x} | ${i.y} | ${i.realm} |\n`);
		}
		allyresult += "+-----+-----+-----+-----+\n";
		allyresult += "```";
		message.channel.send(allyresult);
	}

	///End Allies Command

		///Start Add Pin Command
		if (command === 'pin') {
			if (!args.length) {
				return message.channel.send('You need add the clan name, x,y realm!');
			}
			fetch(`{api-url}/pins/add.php`, {
				method: 'POST',
				body: JSON.stringify({
					clan: args[0],
					x: args[1],
					y: args[2],
					realm: args[3],
					server: message.guild.id
				})
			}).then(function (response) {
				message.channel.send(`added`);
				console.log('add pin request');
				console.log(JSON.stringify({
					clan: args[0],
					x: args[1],
					y: args[2],
					realm: args[3],
					server: message.guild.id
				}));
			})
		}
		///End Add Pin Command

	///Start Help Command
	if (command === 'help') {
		if (!args.length) {
			message.channel.send('Search for someones allies using `!allies owner`\n\nList someones allies using `!list owner`\n\nAdd an ally using `!add name value owner clan`\n\nUpdate an ally using `!update name value owner clan`\n\nDelete an ally using `!delete name`\n\nList allies gathered for specific clans `!clan clan`\n\nShow all clans in database `!clanlist`\n\nSearch specific price `!value 300m` or `!value 133415849`\n\nList clan pins `!pins 95` or `!pins 23`\n\nAdd a pin using `!pin clan x y realm`\n\n');
		}
	}
	///End Help Command
	
});

client.login(token);