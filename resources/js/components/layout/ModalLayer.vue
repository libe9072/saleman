/**
 * ModalLayer.vue
 * @author libe90
 * @date   2019-12-09
 * @comment 풀화면 모달창 용 공통화면 파일
 */
<template>
	<v-dialog
		scrollable
		persistent
		:width="fullWidth ? '' : setWidth ? setWidth : '800'"
		v-model="show"
		transition="dialog-bottom-transition"
	>
		<v-card
			:class="fullWidth ? 'fullScreenD' : ''"
			style="background: #ecedee !important"
		>
			<v-card-title class="pa-0">
				<v-toolbar dark color="primary" height="50px">
					<v-btn
						v-if="
							typeof topProps.closeNotUseYn === 'undefined' ||
							topProps.closeNotUseYn === 'N'
						"
						icon
						dark
						@click="show = false"
					>
						<v-icon>mdi-close</v-icon>
					</v-btn>
					<v-spacer></v-spacer>
					<v-toolbar-title
						class="overflow-visible subtitle-2"
						v-if="changeTitle"
						>{{ changeTitle }}</v-toolbar-title
					>
					<v-toolbar-title
						class="overflow-visible subtitle-2"
						v-else
						>{{ topProps.title }}</v-toolbar-title
					>
					<div class="flex-grow-1"></div>
					<v-toolbar-items style="min-width: 48px">
						<v-btn
							:loading="
								typeof topProps.isLoad !== 'undefined' &&
								topProps.isLoad === true
							"
							dark
							text
							@click="nextClick"
							v-if="topProps.nextYn"
						>
							{{ topProps.nextText }}
							<v-icon>mdi-{{ topProps.nextIcon }}</v-icon>
						</v-btn>
					</v-toolbar-items>
				</v-toolbar>
			</v-card-title>
			<v-card-text class="pa-0">
				<slot name="viewContent"></slot>
			</v-card-text>
		</v-card>
	</v-dialog>
</template>

<script>
import { commonModal } from "../mixins/commonModal";

export default {
	props: {
		topProps: {
			//상태과 정보
			default: "",
		},
		changeTitle: {
			default: null,
		},
		fullCheck: {
			default: false,
		},
		setWidth: {
			default: null,
		},
	},
	data: () => ({
		isMobile: false,
		fullWidth: false,
	}),
	methods: {
		nextClick() {
			//Next버튼용 부모창 호출정보
			this.$emit("nextClick");
		},
		onResize() {
			this.isMobile = window.innerWidth < 960;
			if (this.isMobile === true) {
				this.fullWidth = true;
			} else {
				this.fullWidth = false;
			}
		},
		FnfullCheck() {
			if (this.fullCheck === true) {
				this.fullWidth = true;
			} else {
				this.onResize();
			}
		},
	},
	mounted() {
		this.FnfullCheck();
		window.addEventListener("resize", this.FnfullCheck, { passive: true });
	},
	mixins: [commonModal],
};
</script>
