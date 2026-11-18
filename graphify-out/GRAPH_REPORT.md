# Graph Report - pc-ipm-api  (2026-11-18)

## Corpus Check
- 207 files · ~65,489 words
- Verdict: corpus is large enough that graph structure adds value.
- Unclassified: 29 file(s) not represented in the graph (top: (none) 19, .css 5, .example 1)

## Summary
- 4137 nodes · 10423 edges · 199 communities (110 shown, 89 thin omitted)
- Extraction: 89% EXTRACTED · 11% INFERRED · 0% AMBIGUOUS · INFERRED: 1150 edges (avg confidence: 0.85)
- Token cost: 0 input · 0 output

## Community Hubs (Navigation)
- chart.js: components/chart.js
- Module rich-editor.js
- chart.js: stat/chart.js
- Module markdown-editor.js
- Module rich-editor.js
- Module chart.js
- Module chart.js
- Module chart.js
- Module rich-editor.js
- Module chart.js
- Module support.js
- Module markdown-editor.js
- Module Artikel.php
- Module markdown-editor.js
- Module rich-editor.js
- Module chart.js
- Module markdown-editor.js
- Module chart.js
- Module markdown-editor.js
- Module support.js
- Module notifications.js
- Module chart.js
- Module chart.js
- Module ListAlbumGaleris.php
- Module EditAlbumGaleri.php
- Module AlbumGaleriController.php
- Module support.js
- Module rich-editor.js
- Module chart.js
- Module chart.js
- Module file-upload.js
- Module chart.js
- Module rich-editor.js
- Module chart.js
- Module chart.js
- Module chart.js
- Module docker-compose.yml
- Module chart.js
- Module chart.js
- Module chart.js
- Module CreateAlbumGaleri.php
- Module rich-editor.js
- Module echo.js
- Module markdown-editor.js
- Module chart.js
- Module chart.js
- Module rich-editor.js
- AlbumGaleriResource.php: AlbumGaleriResource
- Module PengeluaranResource.php
- Module support.js
- Module markdown-editor.js
- Module rich-editor.js
- Module support.js
- Module chart.js
- Module PembayaranKasResource.php
- Module support.js
- RolePolicy.php: Role
- Module package.json
- Module chart.js
- Module chart.js
- Module select.js
- Module chart.js
- RolePermissionSeeder.php: Role.php
- app.js: filament/app.js
- Module rich-editor.js
- Module chart.js
- Kajian.php: ImageHelper.php
- Pengurus.php: AlbumGaleri.php
- Module AdminPanelProvider.php
- Module select.js
- Module chart.js
- Module LaporanKas.php
- Module rich-editor.js
- Module markdown-editor.js
- Module rich-editor.js
- Module rich-editor.js
- Module chart.js
- Module chart.js
- Module chart.js
- Module chart.js
- 2025_11_10_031805_create_permission_tables.php: 
- Module color-picker.js
- Module rich-editor.js
- Module rich-editor.js
- DEPLOYMENT.md: AdminPanelProvider
- Module AppServiceProvider.php
- Module select.js
- Module select.js
- app.php: bootstrap/app.php
- Module rich-editor.js
- Module RekapPembayaranKas.php
- Module date-time-picker.js
- Module KajianResource.php
- Module echo.js
- Module echo.js
- Module select.js
- ThrottleByIp.php: SecurityHeaders.php
- Module StorePesanMasukRequest.php
- composer.json: require
- Module 2025_11_08_191901_create_artikels_table.p
- Module 2025_11_09_024219_create_kajians_table.ph
- Module echo.js
- Module file-upload.js
- Module file-upload.js
- Module support.js
- Module composer.json
- composer.json: pestphp/pest-plugin
- composer.json: require-dev
- Module UserFactory.php
- Module echo.js
- Module file-upload.js
- composer.json: autoload
- Module 0001_01_01_000002_create_jobs_table.php
- ExampleTest.php: Illuminate\Foundation\Testing\T
- Module select.js
- Module select.js
- Module select.js
- Module select.js
- Module chart.js
- PengaturanResource.php: PengaturanResource
- PengurusResource.php: PengurusResource
- UserResource.php: UserResource
- composer.json: scripts
- Module 0001_01_01_000001_create_cache_table.php
- Module 2025_11_08_191921_create_kegiatans_table.
- Module 2025_11_09_031149_drop_kas_bulanan_lunas_
- Module 2026_01_03_002257_add_jenis_to_kajians_ta
- Module file-upload.js
- Module markdown-editor.js
- Module rich-editor.js
- Module select.js
- Module chart.js
- ArtikelResource.php: ArtikelResource
- BidangResource.php: BidangResource
- Module 2025_11_08_131529_create_bidangs_table.ph
- Module 2025_11_09_031637_create_pembayaran_kas_t
- Module 2025_11_13_131547_create_slides_table.php
- Module 2025_11_13_131602_create_album_galeris_ta
- Module 2025_11_13_131614_create_foto_galeris_tab
- Module 2025_11_13_131627_create_pesan_masuks_tab
- Module 2025_11_13_131637_create_pengaturans_tabl
- Module 2025_12_03_003300_create_personal_access_
- ExampleTest.php: PHPUnit\Framework\TestCase
- composer.json: autoload-dev
- composer.json: extra
- Module chart.js
- Module entrypoint.sh
- Module support.js

## God Nodes (most connected - your core abstractions)
1. `x()` - 87 edges
2. `update()` - 78 edges
3. `update()` - 75 edges
4. `te()` - 73 edges
5. `V()` - 64 edges
6. `constructor()` - 55 edges
7. `Cn()` - 52 edges
8. `ge()` - 48 edges
9. `Ae()` - 47 edges
10. `ne()` - 44 edges

## Surprising Connections (you probably didn't know these)
- `Database Schema (Core & Application Tables)` --references--> `PesanMasuk`  [INFERRED]
  README.md → app/Models/PesanMasuk.php
- `Nginx Storage Location Prefix Fix (^~ /storage/)` --conceptually_related_to--> `KajianResource`  [INFERRED]
  DEPLOYMENT.md → app/Filament/Resources/KajianResource.php
- `Filament Admin Panel (/admin)` --references--> `PembayaranKasResource`  [INFERRED]
  README.md → app/Filament/Resources/PembayaranKasResource.php
- `Sistem Pembayaran Kas (Monthly Member Dues)` --conceptually_related_to--> `RekapPembayaranKas`  [INFERRED]
  README.md → app/Filament/Resources/PembayaranKasResource/Pages/RekapPembayaranKas.php
- `Filament Admin Panel (/admin)` --references--> `PengaturanResource`  [INFERRED]
  README.md → app/Filament/Resources/PengaturanResource.php

## Import Cycles
- None detected.

## Communities (199 total, 89 thin omitted)

### Community 0 - "chart.js: components/chart.js"
Cohesion: 0.01
Nodes (123): acquireContext(), add(), addControllers(), addEventListener(), addPlugins(), addScales(), ae(), _animateOptions() (+115 more)

### Community 1 - "Module rich-editor.js"
Cohesion: 0.01
Nodes (85): activateAttributeIfSupported(), attachmentForFile(), attachmentIsManaged(), attributesForFile(), box(), canAcceptDataTransfer(), canRedo(), canUndo() (+77 more)

### Community 2 - "chart.js: stat/chart.js"
Cohesion: 0.02
Nodes (87): aa(), add(), addControllers(), addPlugins(), addScales(), an(), _animateOptions(), beforeDatasetDraw() (+79 more)

### Community 3 - "Module markdown-editor.js"
Cohesion: 0.04
Nodes (105): Aa(), af(), ai(), al(), An(), bf(), bo(), cf() (+97 more)

### Community 4 - "Module rich-editor.js"
Cohesion: 0.03
Nodes (89): addAttributeAtRange(), addAttributesAtRange(), appendText(), applyBlockAttributeAtRange(), consolidate(), consolidateBlocksAtRange(), consolidateFromIndexToIndex(), constructor() (+81 more)

### Community 5 - "Module chart.js"
Cohesion: 0.04
Nodes (86): afterBuildTicks(), afterCalculateLabelRotation(), afterDataLimits(), afterFit(), afterSetDimensions(), afterTickToLabelConversion(), afterUpdate(), beforeBuildTicks() (+78 more)

### Community 6 - "Module chart.js"
Cohesion: 0.05
Nodes (85): _a(), adjustHitBoxes(), r(), ba(), Bn(), s(), buildTicks(), calculateLabelRotation() (+77 more)

### Community 7 - "Module chart.js"
Cohesion: 0.04
Nodes (79): afterBuildTicks(), afterCalculateLabelRotation(), afterDataLimits(), afterFit(), afterSetDimensions(), afterUpdate(), beforeBuildTicks(), beforeCalculateLabelRotation() (+71 more)

### Community 8 - "Module rich-editor.js"
Cohesion: 0.05
Nodes (78): attachmentManagerDidRequestRemovalOfAttachment(), breakFormattedBlock(), canDecreaseBlockAttributeLevel(), canDecreaseNestingLevel(), canIncreaseNestingLevel(), canSetCurrentAttribute(), canSetCurrentBlockAttribute(), canSetCurrentTextAttribute() (+70 more)

### Community 9 - "Module chart.js"
Cohesion: 0.04
Nodes (77): addElements(), afterTickToLabelConversion(), ah(), aspectRatio(), au(), beforeTickToLabelConversion(), buildOrUpdateElements(), _calculateBarIndexPixels() (+69 more)

### Community 10 - "Module support.js"
Cohesion: 0.08
Nodes (59): _a(), aa(), ba(), Be(), br(), Ca(), ce(), co() (+51 more)

### Community 11 - "Module markdown-editor.js"
Cohesion: 0.07
Nodes (67): be(), _a(), a(), Ae(), ar(), as(), Ba(), Bc() (+59 more)

### Community 12 - "Module Artikel.php"
Cohesion: 0.06
Nodes (11): Artikel, Bidang, FotoGaleri, Kajian, Kegiatan, PembayaranKas, Pengaturan, Pengeluaran (+3 more)

### Community 13 - "Module markdown-editor.js"
Cohesion: 0.15
Nodes (63): at(), B(), he(), br(), Bt(), ca(), Cr(), Ct() (+55 more)

### Community 14 - "Module rich-editor.js"
Cohesion: 0.05
Nodes (59): add(), attachFiles(), backspace(), beforeinput(), canApplyToDocument(), compositionend(), compositionstart(), compositionupdate() (+51 more)

### Community 15 - "Module chart.js"
Cohesion: 0.06
Nodes (55): uu(), yu(), al(), applyStack(), as(), aspectRatio(), C(), _calculateBarIndexPixels() (+47 more)

### Community 16 - "Module markdown-editor.js"
Cohesion: 0.04
Nodes (8): Bi(), bn(), Id(), ji(), qd(), Ri(), te(), Vi()

### Community 17 - "Module chart.js"
Cohesion: 0.07
Nodes (53): bc(), Bl(), clear(), _computeGridLineItems(), _computeLabelArea(), _computeTitleHeight(), cr(), da() (+45 more)

### Community 18 - "Module markdown-editor.js"
Cohesion: 0.19
Nodes (48): $c(), X(), me(), D(), E(), g(), H(), _i() (+40 more)

### Community 19 - "Module support.js"
Cohesion: 0.14
Nodes (46): parser(), Cn(), b(), Bt(), Ct(), dn(), Dt(), Ft() (+38 more)

### Community 20 - "Module notifications.js"
Cohesion: 0.06
Nodes (23): actions(), button(), constructor(), danger(), dispatch(), dispatchSelf(), dispatchTo(), duration() (+15 more)

### Community 21 - "Module chart.js"
Cohesion: 0.06
Nodes (47): ad(), As(), B(), bh(), bi(), Cc(), Ce(), _computeLabelSizes() (+39 more)

### Community 22 - "Module chart.js"
Cohesion: 0.07
Nodes (47): adjustHitBoxes(), afterAutoSkip(), buildLookupTable(), buildTicks(), calculateCircumference(), calculateLabelRotation(), _calculatePadding(), _circumference() (+39 more)

### Community 24 - "Module ListAlbumGaleris.php"
Cohesion: 0.06
Nodes (15): ListAlbumGaleris, ListArtikels, ListBidangs, ListFotoGaleris, ListKajians, ListKegiatans, ListPembayaranKas, ListPengaturans (+7 more)

### Community 25 - "Module EditAlbumGaleri.php"
Cohesion: 0.06
Nodes (15): EditAlbumGaleri, EditArtikel, EditBidang, EditFotoGaleri, EditKajian, EditKegiatan, EditPembayaranKas, EditPengaturan (+7 more)

### Community 26 - "Module AlbumGaleriController.php"
Cohesion: 0.10
Nodes (14): AlbumGaleriController, ArtikelController, BidangController, HeroSlideController, KajianController, KegiatanController, PengaturanController, PengurusController (+6 more)

### Community 27 - "Module support.js"
Cohesion: 0.17
Nodes (40): a(), ar(), q(), Bi(), I(), c(), H(), d() (+32 more)

### Community 28 - "Module rich-editor.js"
Cohesion: 0.07
Nodes (39): canBeConsolidatedWith(), canBeGrouped(), canBeGroupedWith(), dialogIsVisible(), didClickActionButton(), didClickAttributeButton(), didKeyDownDialogInput(), eachAttributeButton() (+31 more)

### Community 29 - "Module chart.js"
Cohesion: 0.07
Nodes (39): bd(), bt(), _d(), defaultZone(), dg(), Di(), dl(), Dt() (+31 more)

### Community 30 - "Module chart.js"
Cohesion: 0.07
Nodes (38): alpha(), darken(), desaturate(), Gc(), greyscale(), hslString(), _i(), ih() (+30 more)

### Community 31 - "Module file-upload.js"
Cohesion: 0.07
Nodes (19): c(), constructor(), define(), e(), getExtension(), _getTestState(), getType(), Ip() (+11 more)

### Community 32 - "Module chart.js"
Cohesion: 0.09
Nodes (37): _a(), ar(), ba(), cl(), _computeLabelSizes(), createResolver(), D(), Eo() (+29 more)

### Community 33 - "Module rich-editor.js"
Cohesion: 0.06
Nodes (36): attachmentDidChangeAttributes(), attachmentDidChangeUploadProgress(), cacheViewForObject(), createAttachmentNodes(), createCaptionElement(), createChildView(), createContainerElement(), createContentNodes() (+28 more)

### Community 34 - "Module chart.js"
Cohesion: 0.07
Nodes (34): aa(), ar(), At(), Br(), dtFormatter(), du(), em(), eras() (+26 more)

### Community 35 - "Module chart.js"
Cohesion: 0.07
Nodes (34): alpha(), be(), darken(), desaturate(), en(), fe(), Fs(), ge() (+26 more)

### Community 36 - "Module chart.js"
Cohesion: 0.08
Nodes (33): chartOptionScopes(), months(), tm(), At(), dataset(), ea(), Fa(), getCenterPoint() (+25 more)

### Community 37 - "Module docker-compose.yml"
Cohesion: 0.06
Nodes (31): context, dockerfile, APP_DEBUG, APP_ENV, LOG_CHANNEL, external, networks, mariadb_default (+23 more)

### Community 38 - "Module chart.js"
Cohesion: 0.07
Nodes (30): beforeDatasetDraw(), beforeDatasetsDraw(), beforeDraw(), bu(), cr(), Do(), Eo(), ha() (+22 more)

### Community 39 - "Module chart.js"
Cohesion: 0.07
Nodes (30): Dc(), diff(), diffNow(), Dn(), ei(), endOf(), equals(), format() (+22 more)

### Community 40 - "Module chart.js"
Cohesion: 0.07
Nodes (31): addEventListener(), Bi(), cs(), Ct(), data(), di(), el(), fl() (+23 more)

### Community 41 - "Module CreateAlbumGaleri.php"
Cohesion: 0.12
Nodes (14): CreateAlbumGaleri, CreateArtikel, CreateBidang, CreateFotoGaleri, CreateKajian, CreateKegiatan, CreatePembayaranKas, CreatePengaturan (+6 more)

### Community 42 - "Module rich-editor.js"
Cohesion: 0.07
Nodes (30): applyBlockAttribute(), canSyncDocumentView(), compositionDidChangeDocument(), compositionDidLoadSnapshot(), didUninstallAttachmentEditor(), findRangesOfPieces(), formatter(), freezeSelection() (+22 more)

### Community 43 - "Module echo.js"
Cohesion: 0.09
Nodes (13): a(), ar(), cr(), d(), f(), H(), ji(), L() (+5 more)

### Community 44 - "Module markdown-editor.js"
Cohesion: 0.12
Nodes (28): ad(), cd(), ee(), ue(), Et(), Fc(), fd(), ii() (+20 more)

### Community 45 - "Module chart.js"
Cohesion: 0.08
Nodes (29): Ac(), ci(), Cm(), fi(), formatDateTimeFromString(), formatDurationFromString(), formatWithSystemDefault(), fromFormat() (+21 more)

### Community 46 - "Module chart.js"
Cohesion: 0.09
Nodes (27): applyStack(), determineDataLimits(), l(), Fn(), getDataTimestamps(), _getLabelBounds(), getLabelTimestamps(), getMatchingVisibleMetas() (+19 more)

### Community 47 - "Module rich-editor.js"
Cohesion: 0.12
Nodes (27): appendAttachmentWithAttributes(), appendBlockForAttributesWithElement(), appendBlockForElement(), appendBlockForTextNode(), appendEmptyBlock(), appendPiece(), appendStringToTextAtIndex(), appendStringWithAttributes() (+19 more)

### Community 48 - "AlbumGaleriResource.php: AlbumGaleriResource"
Cohesion: 0.08
Nodes (8): AlbumGaleriResource, FotoGaleriResource, KegiatanResource, PesanMasukResource, RoleResource, Filament Admin Panel (/admin), public/robots.txt (Allow All Crawlers), GET /()

### Community 49 - "Module PengeluaranResource.php"
Cohesion: 0.10
Nodes (4): CreatePengeluaran, PengeluaranResource, PermissionResource, SlideResource

### Community 50 - "Module support.js"
Cohesion: 0.12
Nodes (25): De(), Ae(), B(), de(), dt(), fr(), Ge(), Gt() (+17 more)

### Community 51 - "Module markdown-editor.js"
Cohesion: 0.14
Nodes (25): Ac(), ao(), bl(), Cc(), ce(), Cn(), Dc(), di() (+17 more)

### Community 52 - "Module rich-editor.js"
Cohesion: 0.09
Nodes (25): actionIsExternal(), canInvokeAction(), compositionControllerDidBlur(), compositionControllerDidRender(), compositionControllerDidSyncDocumentView(), compositionDidAddAttachment(), compositionDidChangeAttachmentPreviewURL(), compositionDidChangeCurrentAttributes() (+17 more)

### Community 53 - "Module support.js"
Cohesion: 0.14
Nodes (24): da(), ei(), fa(), Fi(), fn(), S(), Ii(), je() (+16 more)

### Community 54 - "Module chart.js"
Cohesion: 0.09
Nodes (25): Ai(), ca(), ec(), Fc(), G(), getBasePixel(), getBasePosition(), getBaseValue() (+17 more)

### Community 56 - "Module support.js"
Cohesion: 0.13
Nodes (23): at(), ds(), En(), es(), jt(), Ln(), lr(), Nn() (+15 more)

### Community 57 - "RolePolicy.php: Role"
Cohesion: 0.18
Nodes (3): Role, User, RolePolicy

### Community 58 - "Module package.json"
Cohesion: 0.12
Nodes (19): devDependencies, axios@^1.11.0, concurrently@^9.0.1, laravel-vite-plugin@^2.0.0, tailwindcss@^4.0.0, @tailwindcss/vite@^4.0.0, vite@^7.0.7, private (+11 more)

### Community 59 - "Module chart.js"
Cohesion: 0.09
Nodes (23): Af(), afterDatasetsUpdate(), an(), bl(), cf(), ef(), Ff(), Ga() (+15 more)

### Community 60 - "Module chart.js"
Cohesion: 0.09
Nodes (23): al(), cd(), color(), constructor(), data(), Dh(), getMeta(), Hc() (+15 more)

### Community 61 - "Module select.js"
Cohesion: 0.16
Nodes (18): [g](), p(), a(), d(), et(), g(), n(), ot() (+10 more)

### Community 62 - "Module chart.js"
Cohesion: 0.11
Nodes (22): Ch(), dataset(), ee(), Fe(), ia(), index(), isPointInArea(), ka() (+14 more)

### Community 63 - "RolePermissionSeeder.php: Role.php"
Cohesion: 0.12
Nodes (3): DatabaseSeeder, PembayaranKasPermissionSeeder, RolePermissionSeeder

### Community 64 - "app.js: filament/app.js"
Cohesion: 0.19
Nodes (20): B(), C(), D(), H(), I(), J(), O(), T() (+12 more)

### Community 65 - "Module rich-editor.js"
Cohesion: 0.10
Nodes (21): deleteByDrag(), formatIndent(), formatOutdent(), formatRemove(), getCurrentTextAttributes(), getTargetDOMRange(), insertAttachment(), insertAttachments() (+13 more)

### Community 66 - "Module chart.js"
Cohesion: 0.10
Nodes (21): afterAutoSkip(), bf(), buildLookupTable(), Ds(), getBasePixel(), getBasePosition(), getBaseValue(), getDecimalForPixel() (+13 more)

### Community 70 - "Module select.js"
Cohesion: 0.15
Nodes (5): e, Ne(), nt(), Se, xe()

### Community 71 - "Module chart.js"
Cohesion: 0.13
Nodes (20): Ft(), Rs(), addElements(), buildOrUpdateElements(), configure(), constructor(), _dataCheck(), describe() (+12 more)

### Community 72 - "Module LaporanKas.php"
Cohesion: 0.11
Nodes (7): LaporanKas, Authentication & RBAC (Sanctum, Spatie Permission, Filament Shield), Database Schema (Core & Application Tables), README.md (PC IPM Mayong - Backend API), Installation, Artisan Commands & Production Deployment Checklist, Sistem Pembayaran Kas (Monthly Member Dues), Tech Stack (Laravel 11, PHP 8.2, SQLite, Filament 3.2, Sanctum, Spatie Permission, Shield, Vite, Tailwind 4)

### Community 73 - "Module rich-editor.js"
Cohesion: 0.11
Nodes (19): compositionControllerDidFocus(), compositionDidRequestChangingSelectionToLocationRange(), createDOMRangeFromPoint(), createLocationRangeFromDOMRange(), didMouseDown(), domRangeWithinElement(), findAttachmentElementParentForNode(), findLocationFromContainerAndOffset() (+11 more)

### Community 74 - "Module markdown-editor.js"
Cohesion: 0.16
Nodes (15): dd(), df(), f(), gl(), Jl(), lr(), md(), nd() (+7 more)

### Community 75 - "Module rich-editor.js"
Cohesion: 0.13
Nodes (18): didChangeAttributes(), getCacheKey(), getContentType(), getHeight(), getHref(), getPreviewURL(), getType(), getURL() (+10 more)

### Community 76 - "Module rich-editor.js"
Cohesion: 0.12
Nodes (17): createDOMRangeFromLocationRange(), expandSelectionAroundCommonAttribute(), expandSelectionForEditing(), expandSelectionInDirection(), findContainerAndOffsetFromLocation(), findNodeAndOffsetFromLocation(), getClientRectAtLocationRange(), getClientRectsForDOMRange() (+9 more)

### Community 77 - "Module chart.js"
Cohesion: 0.14
Nodes (17): cancel(), _createDescriptors(), _descriptors(), dl(), Do(), gc(), getMaxOverflow(), _notify() (+9 more)

### Community 78 - "Module chart.js"
Cohesion: 0.12
Nodes (15): getSignificantNodesForIndex(), br(), _getUniformDataChanges(), ii(), Ps(), qn(), _r(), _updateHiddenIndices() (+7 more)

### Community 79 - "Module chart.js"
Cohesion: 0.15
Nodes (16): cancel(), _createDescriptors(), _descriptors(), ed(), getMaxOverflow(), nd(), _notify(), notify() (+8 more)

### Community 80 - "Module chart.js"
Cohesion: 0.15
Nodes (15): ac(), Ao(), determineDataLimits(), l(), _getLabelBounds(), getMatchingVisibleMetas(), getMinMax(), _getOtherScale() (+7 more)

### Community 81 - "2025_11_10_031805_create_permission_tables.php: "
Cohesion: 0.21
Nodes (8): {closure#1}(), {closure#2}(), {closure#3}(), {closure#1}(), {closure#2}(), {closure#3}(), {closure#4}(), {closure#5}()

### Community 82 - "Module color-picker.js"
Cohesion: 0.14
Nodes (3): style(), update(), [x]()

### Community 83 - "Module rich-editor.js"
Cohesion: 0.20
Nodes (15): ba(), lt(), sa(), Wp(), Wt(), xa(), checkValidity(), disabled() (+7 more)

### Community 84 - "Module rich-editor.js"
Cohesion: 0.16
Nodes (15): consolidateWith(), copyUsingObjectMap(), copyUsingObjectsFromDocument(), copyWithBaseBlockAttributes(), copyWithoutText(), copyWithText(), findRangesForBlockAttribute(), findRangesForTextAttribute() (+7 more)

### Community 85 - "DEPLOYMENT.md: AdminPanelProvider"
Cohesion: 0.16
Nodes (7): AdminPanelProvider, DEPLOYMENT.md (Deployment Notes - PC IPM API), Livewire Asset Publish & Host Volume Sync, Livewire v3.5.20 Compatibility Downgrade, HTTPS Reverse Proxy Chain (Cloudflare Tunnel -> webstack-nginx -> sidecar nginx -> php-fpm), Nginx Storage Location Prefix Fix (^~ /storage/), Host webstack-nginx vhost (pc-ipm-mayong.conf)

### Community 87 - "Module select.js"
Cohesion: 0.15
Nodes (4): oe, te, ce(), le()

### Community 89 - "app.php: bootstrap/app.php"
Cohesion: 0.22
Nodes (5): {closure#1}(), {closure#2}(), {closure#3}(), {closure#4}(), {closure#5}()

### Community 90 - "Module rich-editor.js"
Cohesion: 0.15
Nodes (13): addAttribute(), breaksOnReturn(), copyWithAdditionalAttributes(), copyWithAttributes(), copyWithoutAttribute(), copyWithoutAttributes(), eachBlock(), getLastAttribute() (+5 more)

### Community 92 - "Module date-time-picker.js"
Cohesion: 0.24
Nodes (8): e(), i(), l(), Ni(), o(), t(), u(), Oi()

### Community 93 - "Module KajianResource.php"
Cohesion: 0.22
Nodes (3): {closure#2}(), {closure#3}(), KajianResource

### Community 94 - "Module echo.js"
Cohesion: 0.20
Nodes (10): Be(), ei(), le(), ni(), r(), ri(), te(), ti() (+2 more)

### Community 95 - "Module echo.js"
Cohesion: 0.20
Nodes (10): Ht(), Ie(), ii(), Me(), oi(), Re(), rr(), t() (+2 more)

### Community 96 - "Module select.js"
Cohesion: 0.22
Nodes (3): ae(), ce, He

### Community 99 - "composer.json: require"
Cohesion: 0.22
Nodes (9): require, bezhansalleh/filament-shield, filament/filament, laravel/framework, laravel/sanctum, laravel/tinker, livewire/livewire, php (+1 more)

### Community 102 - "Module echo.js"
Cohesion: 0.22
Nodes (9): Ce(), Dt(), Fe(), He(), ir(), Mt(), nr(), rt() (+1 more)

### Community 103 - "Module file-upload.js"
Cohesion: 0.25
Nodes (9): ca(), _p(), rl(), Rp(), Sp(), vp(), xt(), Ye() (+1 more)

### Community 104 - "Module file-upload.js"
Cohesion: 0.39
Nodes (9): de(), Fe(), Gt(), j(), je(), le(), vt(), zl() (+1 more)

### Community 105 - "Module support.js"
Cohesion: 0.33
Nodes (9): ai(), Ua(), uo(), E(), f(), I(), m(), O() (+1 more)

### Community 106 - "Module composer.json"
Cohesion: 0.25
Nodes (7): description, keywords, license, minimum-stability, name, prefer-stable, type

### Community 107 - "composer.json: pestphp/pest-plugin"
Cohesion: 0.25
Nodes (8): pestphp/pest-plugin, php-http/discovery, config, allow-plugins, optimize-autoloader, preferred-install, process-timeout, sort-packages

### Community 108 - "composer.json: require-dev"
Cohesion: 0.25
Nodes (8): require-dev, fakerphp/faker, laravel/pint, laravel/sail, mockery/mockery, nunomaduro/collision, phpunit/phpunit, spatie/laravel-ignition

### Community 110 - "Module echo.js"
Cohesion: 0.25
Nodes (7): b(), di(), e(), g(), i(), P(), xr()

### Community 111 - "Module file-upload.js"
Cohesion: 0.29
Nodes (7): bi(), jp(), ol(), Tp(), xl(), xp(), yl()

### Community 112 - "composer.json: autoload"
Cohesion: 0.33
Nodes (6): autoload, files, psr-4, App\\, Database\\Factories\\, Database\\Seeders\\

### Community 113 - "Module 0001_01_01_000002_create_jobs_table.php"
Cohesion: 0.33
Nodes (3): {closure#1}(), {closure#2}(), {closure#3}()

### Community 119 - "Module chart.js"
Cohesion: 0.33
Nodes (4): cu(), hu(), lu(), ya()

### Community 123 - "composer.json: scripts"
Cohesion: 0.40
Nodes (5): scripts, post-autoload-dump, post-create-project-cmd, post-root-package-install, post-update-cmd

### Community 129 - "Module file-upload.js"
Cohesion: 0.60
Nodes (5): clickPercent(), getPosition(), mouseUp(), moveplayhead(), timelineClicked()

### Community 130 - "Module markdown-editor.js"
Cohesion: 0.80
Nodes (5): yd(), A(), ee(), j(), m()

### Community 131 - "Module rich-editor.js"
Cohesion: 0.40
Nodes (5): attributeChangedCallback(), disconnectedCallback(), reconnect(), removeInternalToolbar(), Kn()

### Community 133 - "Module chart.js"
Cohesion: 0.50
Nodes (5): En(), On(), Pe(), Po(), vf()

### Community 146 - "composer.json: autoload-dev"
Cohesion: 0.67
Nodes (3): autoload-dev, psr-4, Tests\\

### Community 147 - "composer.json: extra"
Cohesion: 0.67
Nodes (3): extra, laravel, dont-discover

### Community 148 - "Module chart.js"
Cohesion: 0.67
Nodes (3): didClickDialogButton(), cn(), er()

## Knowledge Gaps
- **89 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `Kn()` connect `Module rich-editor.js` to `chart.js: components/chart.js`, `Module rich-editor.js`, `Module chart.js`, `Module support.js`, `Module markdown-editor.js`?**
  _High betweenness centrality (0.084) - this node is a cross-community bridge._
- **Are the 13 inferred relationships involving `x()` (e.g. with `X()` and `g()`) actually correct?**
  _`x()` has 13 INFERRED edges - model-reasoned connections that need verification._
- **Should `chart.js: components/chart.js` be split into smaller, more focused modules?**
  _Cohesion score 0.008245817194425588 - nodes in this community are weakly interconnected._
- **Why does `constructor()` connect `Module rich-editor.js` to `Module rich-editor.js`, `Module markdown-editor.js`, `Module rich-editor.js`, `Module chart.js`, `Module rich-editor.js`, `Module markdown-editor.js`, `Module rich-editor.js`, `Module rich-editor.js`, `Module rich-editor.js`, `Module rich-editor.js`, `Module support.js`, `Module rich-editor.js`, `Module rich-editor.js`?**
  _High betweenness centrality (0.053) - this node is a cross-community bridge._
- **Are the 19 inferred relationships involving `te()` (e.g. with `je()` and `Pr()`) actually correct?**
  _`te()` has 19 INFERRED edges - model-reasoned connections that need verification._
- **Should `Module rich-editor.js` be split into smaller, more focused modules?**
  _Cohesion score 0.01306532663316583 - nodes in this community are weakly interconnected._
- **Why does `F()` connect `Module chart.js` to `chart.js: components/chart.js`, `Module chart.js`, `Module chart.js`, `Module chart.js`, `Module chart.js`, `Module chart.js`, `Module support.js`, `Module markdown-editor.js`, `Module chart.js`, `Module chart.js`, `Module color-picker.js`, `Module markdown-editor.js`, `Module support.js`, `Module chart.js`, `Module support.js`, `Module chart.js`?**
  _High betweenness centrality (0.051) - this node is a cross-community bridge._