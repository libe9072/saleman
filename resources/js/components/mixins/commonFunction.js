
/**
 * commonFunction.js
 * @author libe90
 * @date   2019-12-09
 * @comment 공통 펑션
*/
import { mapState } from "vuex";
import dayjs from "dayjs";
export const commonFunction = {
	data: () => ({
		csrfToken: null,
	}),
	props: {
		showSnackBar: { //스넥바 노출여부
			default: false
		},
	},
	methods: {
		dateformat(type, date, format) {
			if (type === 'D') {
				return dayjs(date).format(format)
			} else if (type === 'DD') {
				let today = dayjs();

				let expired_at = dayjs(date);

				let result = expired_at.diff(today, "day", true);

				let d_day = Math.floor(result);
				return d_day;
			} else if (type === 'DM') {
				let today = dayjs();

				let expired_at = dayjs(date);

				let result = expired_at.diff(today, "month", true);

				let d_day = Math.floor(result);
				return d_day;
			}
		},
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
		makeSnakeData(data, color) { // snake message 생성
			let message = {
				"text": data,
				"color": color
			};
			return message;
		},
	},
	computed: {
		...mapState({
			SSEQNO: state => state.sessionData.SSEQNO,
			SNAME: state => state.sessionData.SNAME,
			SUCP: state => state.sessionData.SUCP,
			SADMIN: state => state.sessionData.SADMIN,
		}),
	},
	created() {
		this.csrfToken = document.querySelector('meta[name="csrf-token"]').content;
	},
}
