import{_ as c,M as s,p as r,q as h,R as e,t,N as a,U as n,a1 as d}from"./framework-efe98465.js";const l={},u=d('<h1 id="if-match" tabindex="-1"><a class="header-anchor" href="#if-match" aria-hidden="true">#</a> If-Match</h1><p><strong>Class:</strong> <em><code>\\Aedart\\ETags\\Preconditions\\Rfc9110\\IfMatch</code></em></p><h2 id="applicable" tabindex="-1"><a class="header-anchor" href="#applicable" aria-hidden="true">#</a> Applicable</h2><p>When <code>If-Match</code> header is requested.</p><h2 id="condition" tabindex="-1"><a class="header-anchor" href="#condition" aria-hidden="true">#</a> Condition</h2><ol><li>If <code>If-Match</code> header is &quot;*&quot;, the condition is <strong>true</strong> if a current representation (<em>Etag</em>) exists for the target resource.</li><li>If <code>If-Match</code> header is a list of Etags, the condition is <strong>true</strong> if any of the listed tags match the Etag of the selected representation (<em>the resource</em>).</li><li>Otherwise, the condition is <strong>false</strong>.</li></ol><h2 id="when-it-passes" tabindex="-1"><a class="header-anchor" href="#when-it-passes" aria-hidden="true">#</a> When it passes</h2>',7),f=e("h2",{id:"when-it-fails",tabindex:"-1"},[e("a",{class:"header-anchor",href:"#when-it-fails","aria-hidden":"true"},"#"),t(" When it fails")],-1),_=e("code",null,"POST",-1),p=e("code",null,"PUT",-1),g=e("code",null,"PATCH",-1),m=e("code",null,"hasStateChangeAlreadySucceeded()",-1),v=e("code",null,"abortStateChangeAlreadySucceeded()",-1),x=e("code",null,"GET",-1),b=e("code",null,"HEAD",-1),I=e("code",null,"abortPreconditionFailed()",-1),w=e("h2",{id:"references",tabindex:"-1"},[e("a",{class:"header-anchor",href:"#references","aria-hidden":"true"},"#"),t(" References")],-1),k={href:"https://httpwg.org/specs/rfc9110.html#field.if-match",target:"_blank",rel:"noopener noreferrer"};function E(M,q){const o=s("RouterLink"),i=s("ExternalLinkIcon");return r(),h("div",null,[u,e("p",null,[t("When condition passes, evaluation continues to "),a(o,{to:"/archive/v7x/etags/evaluator/rfc9110/if-none-match.html"},{default:n(()=>[t("If-None-Match precondition")]),_:1}),t(".")]),f,e("p",null,[t("If the request is state-changing, e.g. "),_,t(", "),p,t(", "),g,t("... etc, the precondition will attempt to detect whether the requested state-change has already succeeded or not. This is done via the "),a(o,{to:"/archive/v7x/etags/evaluator/resource-context.html#determine-state-change-success"},{default:n(()=>[m]),_:1}),t(", in the given resource. Should a state-change already have succeeded, then the "),a(o,{to:"/archive/v7x/etags/evaluator/actions.html#abort-state-change-already-succeeded"},{default:n(()=>[v]),_:1}),t(" action method is invoked.")]),e("p",null,[t("When the request is not state-changing, e.g. for "),x,t(", "),b,t(" requests, or when a state-change could not be determined, the "),a(o,{to:"/archive/v7x/etags/evaluator/actions.html#abort-precondition-failed"},{default:n(()=>[I]),_:1}),t(" action method is invoked.")]),w,e("ul",null,[e("li",null,[e("a",k,[t("If-Match specification"),a(i)])])])])}const S=c(l,[["render",E],["__file","if-match.html.vue"]]);export{S as default};
