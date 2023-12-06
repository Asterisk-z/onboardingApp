import { useEffect } from "react";
import { toast } from "react-toastify";
import { useNavigate } from 'react-router-dom';

function Logout(props) {
        const navigate = useNavigate()
	useEffect(() => {
		localStorage.clear();
		toast.success("Logged Out");
		localStorage.removeItem("logger", "");
        navigate(`${process.env.PUBLIC_URL}/login`);
	}, []);
}
export default Logout;
