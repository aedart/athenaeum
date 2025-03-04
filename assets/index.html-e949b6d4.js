import{_ as l,M as i,p as s,q as c,R as t,N as o,U as a,t as e,a1 as h}from"./framework-efe98465.js";const u={},p=t("h1",{id:"release-notes",tabindex:"-1"},[t("a",{class:"header-anchor",href:"#release-notes","aria-hidden":"true"},"#"),e(" Release Notes")],-1),f={class:"table-of-contents"},m=t("h2",{id:"support-policy",tabindex:"-1"},[t("a",{class:"header-anchor",href:"#support-policy","aria-hidden":"true"},"#"),e(" Support Policy")],-1),_={href:"https://laravel.com/docs/12.x/releases",target:"_blank",rel:"noopener noreferrer"},v=h('<table><thead><tr><th>Version</th><th>PHP</th><th>Laravel</th><th>Release</th><th>Security Fixes Until</th></tr></thead><tbody><tr><td><code>10.x</code></td><td><code>8.4 - ?</code></td><td><code>v13.x</code></td><td><em>~1st Quarter 2026</em></td><td><em>TBD</em></td></tr><tr><td><code>9.x</code>*</td><td><code>8.3 - 8.4</code></td><td><code>v12.x</code></td><td>March 4th, 2025</td><td>February 2026</td></tr><tr><td><code>8.x</code></td><td><code>8.2 - 8.3</code></td><td><code>v11.x</code></td><td>March 18th, 2024</td><td>February 2025</td></tr><tr><td><code>7.x</code></td><td><code>8.1 - 8.2</code></td><td><code>v10.x</code></td><td>February 16th, 2023</td><td>March 2024</td></tr><tr><td><code>6.x</code></td><td><code>8.0 - 8.1</code></td><td><code>v9.x</code></td><td>April 5th, 2022</td><td>February 2023</td></tr><tr><td><code>&lt; 6.x</code></td><td><em>-</em></td><td><em>-</em></td><td><em>See <code>CHANGELOG.md</code></em></td><td><em>N/A</em></td></tr></tbody></table><p><em>*: current supported version.</em></p><p><em>TBD: &quot;To be decided&quot;.</em></p><h2 id="v9-x-highlights" tabindex="-1"><a class="header-anchor" href="#v9-x-highlights" aria-hidden="true">#</a> <code>v9.x</code> Highlights</h2><p>These are the highlights of the latest major version of Athenaeum.</p><h3 id="php-v8-3-and-laravel-v12-x" tabindex="-1"><a class="header-anchor" href="#php-v8-3-and-laravel-v12-x" aria-hidden="true">#</a> PHP <code>v8.3</code> and Laravel <code>v12.x</code></h3>',6),x=t("code",null,"v8.3",-1),g={href:"https://laravel.com/docs/12.x/releases",target:"_blank",rel:"noopener noreferrer"},b=t("code",null,"v12.x",-1),y=t("h3",{id:"randomizer-float-nextfloat-and-bytesfromstring",tabindex:"-1"},[t("a",{class:"header-anchor",href:"#randomizer-float-nextfloat-and-bytesfromstring","aria-hidden":"true"},"#"),e(" Randomizer "),t("code",null,"float()"),e(", "),t("code",null,"nextFloat()"),e(" and "),t("code",null,"bytesFromString()")],-1),w=t("code",null,"NumericRandomizer",-1),k=t("code",null,"float()",-1),A=t("code",null,"nextFloat()",-1),F=t("code",null,"StringRandomizer",-1),P=t("code",null,"bytesFromString()",-1),R=t("h3",{id:"environment-file-utility",tabindex:"-1"},[t("a",{class:"header-anchor",href:"#environment-file-utility","aria-hidden":"true"},"#"),e(" Environment File utility")],-1),T=t("p",null,[e("The "),t("code",null,"EnvFile"),e(" can be used for replacing the value of an existing key, or appending a new key-value pair, in the application's environment file.")],-1),S=t("h3",{id:"redmine-v6-0-x-api",tabindex:"-1"},[t("a",{class:"header-anchor",href:"#redmine-v6-0-x-api","aria-hidden":"true"},"#"),e(" Redmine "),t("code",null,"v6.0.x"),e(" API")],-1),L={href:"https://www.redmine.org/projects/redmine/wiki/Rest_api",target:"_blank",rel:"noopener noreferrer"},E=t("code",null,"v6.0.x",-1),N=t("h3",{id:"auth-exceptions-and-responses",tabindex:"-1"},[t("a",{class:"header-anchor",href:"#auth-exceptions-and-responses","aria-hidden":"true"},"#"),e(" Auth Exceptions and Responses")],-1),H=t("p",null,"The Auth package has received a few new components, intended to be used in combination with for Laravel Fortify. Among them are a few predefined exceptions and response helpers.",-1),j=t("h3",{id:"toml-version-1-0-0-supported",tabindex:"-1"},[t("a",{class:"header-anchor",href:"#toml-version-1-0-0-supported","aria-hidden":"true"},"#"),e(" TOML version 1.0.0 Supported")],-1),V={href:"https://github.com/toml-lang/toml",target:"_blank",rel:"noopener noreferrer"},z=t("code",null,"1.0.0",-1),C=t("h3",{id:"additional-parameters-for-json-isvalid",tabindex:"-1"},[t("a",{class:"header-anchor",href:"#additional-parameters-for-json-isvalid","aria-hidden":"true"},"#"),e(" Additional parameters for "),t("code",null,"Json::isValid()")],-1),M=t("p",null,[e("The "),t("code",null,"Json::isValid()"),e(" now accepts "),t("code",null,"$depth"),e(" and "),t("code",null,"$options"),e(" as optional parameters.")],-1),B=t("h3",{id:"deprecation-of-aware-of-properties",tabindex:"-1"},[t("a",{class:"header-anchor",href:"#deprecation-of-aware-of-properties","aria-hidden":"true"},"#"),e(' Deprecation of "Aware-of" Properties')],-1),I=t("h2",{id:"changelog",tabindex:"-1"},[t("a",{class:"header-anchor",href:"#changelog","aria-hidden":"true"},"#"),e(" Changelog")],-1),q={href:"https://github.com/aedart/athenaeum/blob/master/CHANGELOG.md",target:"_blank",rel:"noopener noreferrer"};function D(G,O){const n=i("router-link"),d=i("ExternalLinkIcon"),r=i("RouterLink");return s(),c("div",null,[p,t("nav",f,[t("ul",null,[t("li",null,[o(n,{to:"#support-policy"},{default:a(()=>[e("Support Policy")]),_:1})]),t("li",null,[o(n,{to:"#v9-x-highlights"},{default:a(()=>[e("v9.x Highlights")]),_:1}),t("ul",null,[t("li",null,[o(n,{to:"#php-v8-3-and-laravel-v12-x"},{default:a(()=>[e("PHP v8.3 and Laravel v12.x")]),_:1})]),t("li",null,[o(n,{to:"#randomizer-float-nextfloat-and-bytesfromstring"},{default:a(()=>[e("Randomizer float(), nextFloat() and bytesFromString()")]),_:1})]),t("li",null,[o(n,{to:"#environment-file-utility"},{default:a(()=>[e("Environment File utility")]),_:1})]),t("li",null,[o(n,{to:"#redmine-v6-0-x-api"},{default:a(()=>[e("Redmine v6.0.x API")]),_:1})]),t("li",null,[o(n,{to:"#auth-exceptions-and-responses"},{default:a(()=>[e("Auth Exceptions and Responses")]),_:1})]),t("li",null,[o(n,{to:"#toml-version-1-0-0-supported"},{default:a(()=>[e("TOML version 1.0.0 Supported")]),_:1})]),t("li",null,[o(n,{to:"#additional-parameters-for-json-isvalid"},{default:a(()=>[e("Additional parameters for Json::isValid()")]),_:1})]),t("li",null,[o(n,{to:"#deprecation-of-aware-of-properties"},{default:a(()=>[e('Deprecation of "Aware-of" Properties')]),_:1})])])]),t("li",null,[o(n,{to:"#changelog"},{default:a(()=>[e("Changelog")]),_:1})])])]),m,t("p",null,[e("Athenaeum attempts to follow a release cycle that matches closely to that of "),t("a",_,[e("Laravel"),o(d)]),e(". However, due to limited amount of project maintainers, no guarantees can be provided.")]),v,t("p",null,[e("PHP version "),x,e(" is now the minimum required version for Athenaeum. "),t("a",g,[e("Laravel "),b,o(d)]),e(" packages are now used.")]),y,t("p",null,[w,e(" now supports generating random floats via "),o(r,{to:"/archive/current/utils/math.html#float"},{default:a(()=>[k]),_:1}),e(" and "),o(r,{to:"/archive/current/utils/math.html#nextfloat"},{default:a(()=>[A]),_:1}),e(". Additionally, the "),F,e(" now offers a "),o(r,{to:"/archive/current/utils/string.html#bytesfromstring"},{default:a(()=>[P]),_:1}),e(" method.")]),R,T,t("p",null,[e("See "),o(r,{to:"/archive/current/support/env-file.html"},{default:a(()=>[e("Support package documentation")]),_:1}),e(" for details.")]),S,t("p",null,[e("The "),o(r,{to:"/archive/current/redmine/"},{default:a(()=>[e("Redmine Client")]),_:1}),e(" now supports "),t("a",L,[e("Redmine "),E,e(" API"),o(d)]),e(".")]),N,H,t("p",null,[e("See "),o(r,{to:"/archive/current/auth/fortify/"},{default:a(()=>[e("Auth Fortify documentation")]),_:1}),e(" for details.")]),j,t("p",null,[e("The "),o(r,{to:"/archive/current/config/"},{default:a(()=>[e("configuration loader")]),_:1}),e(" now supports "),t("a",V,[e("toml"),o(d)]),e(" version "),z,e(" format.")]),t("p",null,[e("Please see the "),o(r,{to:"/archive/current/upgrade-guide.html"},{default:a(()=>[e("upgrade guide")]),_:1}),e(" for details.")]),C,M,t("p",null,[e("See "),o(r,{to:"/archive/current/utils/json.html#validation"},{default:a(()=>[e("documentation")]),_:1}),e(" for details.")]),B,t("p",null,[e("The "),o(r,{to:"/archive/current/support/properties/available-helpers.html"},{default:a(()=>[e('"aware-of" properties')]),_:1}),e(" have been deprecated. These have served their purpose in the past, but are now no longer relevant. The components will be removed in the next major version. There are no plans to offer any alternatives.")]),I,t("p",null,[e("Make sure to read the "),t("a",q,[e("changelog"),o(d)]),e(" for additional information about the latest release, new features, changes and bug fixes.")])])}const U=l(u,[["render",D],["__file","index.html.vue"]]);export{U as default};
