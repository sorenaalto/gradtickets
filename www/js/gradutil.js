// utils for grad data

function gradutils(gradinfo) {
    this.gradinfo = gradinfo;
    this.seen = {};

    this.parseScan = function(scan) {
        var t = scan.split('_');
        var snum = t[0] ;
        var guest = t.length>1 ? t[1] : null;
        return {'snum':snum,'guest':guest};
    }

    this.sessionList = function() {
        var slist = [];
        for(var ssn in this.gradinfo) {
            slist.push(ssn);
        }
        slist.sort();
        return slist;
    }
    
    this.sessionDateAndTime = function(ssnid) {
        var ssndateS = ssnid.slice(0,8);
        var ssnyr = ssndateS.slice(0,4);
        var ssnmon = ssndateS.slice(4,6);
        var ssnday = ssndateS.slice(6,8);
        var sdate = new Date(ssnyr,ssnmon-1,ssnday);
        var ssntime = ssnid.slice(9,14);
        return {'date':sdate,'time':ssntime};
    }
    
    this.findStudent =  function(sn) {
        for(var ssn in this.gradinfo) {
            if (sn in this.gradinfo[ssn]) {
                return this.gradinfo[ssn][sn];
            }
        }
        return null ;
    }
    
    this.studentSeen = function(snum) {
        if(snum in this.seen) {
            return this.seen[snum];            
        } else {
            return null ;
        }
    }
    
    this.studentGuestSeen = function(snum,guest) {
        var seen = this.studentSeen(snum);
        if(seen == null) {
            return false;
        } else {
            if(guest == null) {
                return true ;
            } else {
                return (guest in seen.guests);
            }
        }
    }
    
    this.seeStudent= function(snum,guest) {
        if(!(snum in this.seen)) {
            this.seen[snum] = {'snum':snum,'guests':new Set()};
        }
        if (guest != null) {
            this.seen[snum].guests.add(guest);
        }
    }
}