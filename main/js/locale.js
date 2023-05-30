function locale(type) {
	return function (text) {
		return lang[type][text]
	}
}