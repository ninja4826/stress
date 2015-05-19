var funcs = {
    substringMatcher: function( strs ) {
        return function findMatches(q, cb) {
            var matches, substrRegex;
            
            matches = [];
            
            substrRegex = new RegExp(q, 'i');
            
            $.each(strs, function(i, str) {
                if (substrRegex.test(str)) {
                    matches.push({ value: str });
                }
            });
            
            cb(matches);
        };
    }
};
for (var f in funcs) {
    window[f] = funcs[f];
}