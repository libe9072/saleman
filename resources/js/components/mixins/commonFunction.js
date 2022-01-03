
/**
 * commonFunction.js
 * @author libe90
 * @date   2019-12-09
 * @comment 공통 펑션
 */
export const commonFunction = {
	data: () => ({
		csrfToken: null,
	}),
	props: {
		showSnackBar: { //스넥바 노출여부
			default: false
		},
		isMobile: { //모바일여부
			default: false
		},
		wFull: { //PC보기여부
			default: false
		}
	},
	methods: {
		setSnackData: function (data) { //스낵바 호출
			this.$emit('snackData', data)
		},
		validate() {   //유효성검사
			this.$refs.form.validate()
		},
		reset() {  //리셋
			Object.assign(this.$data, this.$options.data.call(this))
		},
		nextClick() {
		},
		setConfirmModalData: function (data) {  //컨펌창 호출
			if (this.showConfirmModal === false) {
				this.showConfirmModal = true;
			}
			if (data === undefined) {
				this.showConfirmModal = true;
			} else {
				this.confirmModalProps = data
			}
		},
		makeSnakeData(data, color) { // snake message 생성
			let message = {
				"text": data,
				"color": color
			};
			return message;
		},
	},
	computed: {
	},
	created() {
		this.csrfToken = document.querySelector('meta[name="csrf-token"]').content;
	},
}
