import{_ as s,M as i,p as r,q as d,R as a,t as e,N as n,U as o,a1 as c}from"./framework-efe98465.js";const h={},l=c('<h1 id="range" tabindex="-1"><a class="header-anchor" href="#range" aria-hidden="true">#</a> Range</h1><p><strong>Class:</strong> <em><code>\\Aedart\\ETags\\Preconditions\\Additional\\Range</code></em></p><div class="custom-container warning"><p class="custom-container-title">Note</p><p>This extension is enabled by default in the <code>Evaluator</code>, because a client is able to perform a <code>Range</code> request, without <code>If-Range</code> precondition. When such happens, it is prudent and feasible to perform the same kind of range-set validation, as for the RFC 9110 defined <code>If-Range</code> precondition.</p></div><h2 id="applicable" tabindex="-1"><a class="header-anchor" href="#applicable" aria-hidden="true">#</a> Applicable</h2><p>When the request method is <code>GET</code>, <code>Range</code> header is present, <code>If-Range</code> is NOT present, and the resource supports range requests.</p><h2 id="condition" tabindex="-1"><a class="header-anchor" href="#condition" aria-hidden="true">#</a> Condition</h2>',6),u=a("em",null,"if they are valid",-1),p=a("code",null,"RangeValidator",-1),f=a("h2",{id:"when-it-passes",tabindex:"-1"},[a("a",{class:"header-anchor",href:"#when-it-passes","aria-hidden":"true"},"#"),e(" When it passes")],-1),g=a("code",null,"processRange()",-1),_=a("h2",{id:"when-it-fails",tabindex:"-1"},[a("a",{class:"header-anchor",href:"#when-it-fails","aria-hidden":"true"},"#"),e(" When it fails")],-1),v=a("code",null,"ignoreRange()",-1),m=a("h2",{id:"references",tabindex:"-1"},[a("a",{class:"header-anchor",href:"#references","aria-hidden":"true"},"#"),e(" References")],-1);function x(b,R){const t=i("RouterLink");return r(),d("div",null,[l,a("p",null,[e("If the requested ranges are applicable ("),u,e(") for the requested resource. Validation of ranges is performed via a "),n(t,{to:"/archive/v7x/etags/evaluator/range-validator.html"},{default:o(()=>[p]),_:1}),e(".")]),f,a("p",null,[e("The "),n(t,{to:"/archive/v7x/etags/evaluator/actions.html#process-range"},{default:o(()=>[g]),_:1}),e(" action method is invoked. Evaluator continues to "),n(t,{to:"/archive/v7x/etags/evaluator/extensions/"},{default:o(()=>[e("extensions")]),_:1}),e(", when available. Otherwise, request processing continues.")]),_,a("p",null,[e("The "),n(t,{to:"/archive/v7x/etags/evaluator/actions.html#ignore-range"},{default:o(()=>[v]),_:1}),e(" action method is invoked. Evaluator continues to "),n(t,{to:"/archive/v7x/etags/evaluator/extensions/"},{default:o(()=>[e("extensions")]),_:1}),e(", when available. Otherwise, request processing continues.")]),m,a("ul",null,[a("li",null,[n(t,{to:"/archive/v7x/etags/evaluator/rfc9110/if-range.html"},{default:o(()=>[e("If-Range precondition")]),_:1})])])])}const q=s(h,[["render",x],["__file","range.html.vue"]]);export{q as default};
